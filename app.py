import streamlit as st
import sqlite3

st.set_page_config(
    page_title="Library Management System",
    page_icon="📚",
    layout="wide"
)

conn = sqlite3.connect("library.db", check_same_thread=False)
cursor = conn.cursor()

cursor.execute("""
CREATE TABLE IF NOT EXISTS books (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title TEXT NOT NULL,
    author TEXT NOT NULL,
    quantity INTEGER NOT NULL
)
""")
conn.commit()

st.title("📚 Library Management System")
st.sidebar.title("Navigation")

page = st.sidebar.radio(
    "Select Page",
    ["Dashboard", "Add Book", "View Books", "Search Books"]
)

if page == "Dashboard":
    cursor.execute("SELECT COUNT(*) FROM books")
    total = cursor.fetchone()[0]

    cursor.execute("SELECT COALESCE(SUM(quantity), 0) FROM books")
    copies = cursor.fetchone()[0]

    col1, col2 = st.columns(2)
    col1.metric("Book Titles", total)
    col2.metric("Total Copies", copies)

    st.success("Welcome to your Library Management System!")

elif page == "Add Book":
    with st.form("add_book"):
        title = st.text_input("Book Title")
        author = st.text_input("Author")
        quantity = st.number_input(
            "Quantity", min_value=1, step=1
        )
        submitted = st.form_submit_button("Add Book")

        if submitted:
            if title.strip() and author.strip():
                cursor.execute(
                    "INSERT INTO books (title, author, quantity) VALUES (?, ?, ?)",
                    (title.strip(), author.strip(), quantity)
                )
                conn.commit()
                st.success("Book added successfully!")
            else:
                st.error("Please enter the title and author.")

elif page == "View Books":
    cursor.execute(
        "SELECT id, title, author, quantity FROM books ORDER BY id DESC"
    )
    books = cursor.fetchall()

    if books:
        st.dataframe(
            [
                {
                    "ID": b[0],
                    "Title": b[1],
                    "Author": b[2],
                    "Quantity": b[3]
                }
                for b in books
            ],
            use_container_width=True
        )

        book_id = st.number_input(
            "Book ID to delete", min_value=1, step=1
        )

        if st.button("Delete Book"):
            cursor.execute("DELETE FROM books WHERE id = ?", (book_id,))
            conn.commit()

            if cursor.rowcount:
                st.success("Book deleted.")
                st.rerun()
            else:
                st.warning("Book ID not found.")
    else:
        st.info("No books added yet.")

elif page == "Search Books":
    search = st.text_input("Search by title or author")

    cursor.execute(
        "SELECT id, title, author, quantity FROM books "
        "WHERE title LIKE ? OR author LIKE ?",
        (f"%{search}%", f"%{search}%")
    )
    results = cursor.fetchall()

    st.dataframe(
        [
            {
                "ID": b[0],
                "Title": b[1],
                "Author": b[2],
                "Quantity": b[3]
            }
            for b in results
        ],
        use_container_width=True
    )

conn.close()