package service;

import java.sql.Connection;
import java.sql.ResultSet;
import java.util.*;

import javax.jws.WebService;
import javax.xml.transform.Result;

import model.Book;
import org.json.JSONArray;
import org.json.JSONException;
import utility.GoogleBookAPI;
import org.json.JSONObject;
import utility.DBConnection;

@WebService()
public class BookServiceImpl implements  BookService {
    @Override
    public Book getBookByIdDb(String id) {
        DBConnection bookDb = new DBConnection();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM book WHERE book_id = \"%s\"", id));

        try {
            while(result.next()) {
                String book_id = result.getString("book_id");
                int price = result.getInt("price");
                int orderedCount = result.getInt("ordered_count");
                String category = result.getString("category");

                Book resultBook = new Book(book_id, price, orderedCount, category);

                return resultBook;
            }
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    public int addBook(String id, int price, String category) {
        DBConnection bookDb = new DBConnection();
        int result = bookDb.doPostQuery(String.format("INSERT INTO book(book_id, price, ordered_count, category)" +
            "                                      VALUES(\"%s\", %d, 0, \"%s\")", id, price, category));

        return result;
    }

    public List<Book> getBooksByCategoryGBA(String category) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(category);
        JSONObject hasilJSON = new JSONObject();
        hasilJSON = googleBookAPI.searchByCategory();
        try {
            JSONArray resultItems = new JSONArray(hasilJSON.get("items").toString());
            List<Book> bookResults = new ArrayList<>();

            for(int i = 0; i < Math.min(10, resultItems.length()); i++) {
                String id = "";
                String title = "";
                String[] authors = {""};
                String category_result = "";
                String description = "";
                Integer price = 0;

                JSONObject book = new JSONObject(resultItems.get(i).toString());
                id = book.get("id").toString();

                JSONObject volumeInfo = new JSONObject(book.get("volumeInfo").toString());
                if (volumeInfo.has("title")) {
                    title = volumeInfo.get("title").toString();
                }

                if (volumeInfo.has("authors")) {
                    JSONArray authorsJSON = new JSONArray(volumeInfo.get("authors").toString());
                    authors = new String[authorsJSON.length()];
                    for(int j = 0; j < authorsJSON.length(); j++) {
                        authors[j] = authorsJSON.get(j).toString();
                    }
                }

                if (volumeInfo.has("categories")) {
                    JSONArray categoriesJSON = new JSONArray(volumeInfo.get("categories").toString());
                    for (int j = 0; j < categoriesJSON.length(); j++) {
                        category_result = categoriesJSON.get(j).toString();
                        break;
                    }
                }

                if (volumeInfo.has("description")) {
                    description = volumeInfo.get("description").toString();
                }

                if (book.has("saleInfo")) {
                    JSONObject saleInfo = new JSONObject(book.get("saleInfo").toString());
                    if (saleInfo.has("listPrice")) {
                        JSONObject listPrice = new JSONObject(saleInfo.get("listPrice").toString());
                        if (listPrice.has("amount")) {
                            price = listPrice.getInt("amount");
                        }
                    }
                }

                Book bookResult = new Book(id, title, authors, description, price, category_result);
                Book bookOnDb = this.getBookByIdDb(id);

                if (bookOnDb == null) {
                    int rowBook = this.addBook(id, price, category_result);
                }

                bookResults.add(bookResult);
            }

            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return null;
    }

    @Override
    public Book getBookByIdGBA(String id) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(id);
        JSONObject book;
        book = googleBookAPI.searchById();
        try {
            String book_id = "";
            String title = "";
            String[] authors = {""};
            String category = "";
            String description = "";
            Integer price = 0;

            book_id = book.getString("id");

            JSONObject volumeInfo = new JSONObject(book.get("volumeInfo").toString());
            if (volumeInfo.has("title")) {
                title = volumeInfo.get("title").toString();
            }

            if (volumeInfo.has("authors")) {
                JSONArray authorsJSON = new JSONArray(volumeInfo.get("authors").toString());
                authors = new String[authorsJSON.length()];
                for(int j = 0; j < authorsJSON.length(); j++) {
                    authors[j] = authorsJSON.get(j).toString();
                }
            }

            if (volumeInfo.has("categories")) {
                JSONArray categoriesJSON = new JSONArray(volumeInfo.get("categories").toString());
                for (int j = 0; j < categoriesJSON.length(); j++) {
                    category = categoriesJSON.get(j).toString();
                    break;
                }
            }

            if (volumeInfo.has("description")) {
                description = volumeInfo.get("description").toString();
            }

            if (book.has("saleInfo")) {
                JSONObject saleInfo = new JSONObject(book.get("saleInfo").toString());
                if (saleInfo.has("listPrice")) {
                    JSONObject listPrice = new JSONObject(saleInfo.get("listPrice").toString());
                    if (listPrice.has("amount")) {
                        price = listPrice.getInt("amount");
                    }
                }
            }

            Book bookResult = new Book(book_id, title, authors, description, price, category);

            return bookResult;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    public List<Book> getBooksByCategoryDb(String category) {
        DBConnection bookDb = new DBConnection();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM book WHERE category LIKE \"%s\"", category));

        List<Book> bookResults = new ArrayList<>();

        try {
            while(result.next()) {
                String book_id = result.getString("book_id");
                int price = result.getInt("price");
                int ordered_count = result.getInt("ordered_count");
                String categoryDb = result.getString("category");

                Book bookResult = new Book(book_id, price, ordered_count, categoryDb);
                bookResults.add(bookResult);
            }

            return bookResults;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    @Override
    public Book recommendationBooks(String[] categories) {
        List<Book> results = new ArrayList<>();

        for (int i = 0; i < categories.length; i++ ) {
            String category = categories[i];
            List<Book> bookResults;
            bookResults = this.getBooksByCategoryDb(category);
            for (int j = 0; j < bookResults.size(); j++) {
                results.add(bookResults.get(j));
            }
        }

        Collections.sort(results, new Comparator<Book>() {
            @Override
            public int compare(Book book, Book t1) {
                return book.getOrderedCount() - t1.getOrderedCount();
            }
        });

        if (results.size() != 0) {
            Book bestBook = results.get(0);
            Book bookResult = this.getBookByIdGBA(bestBook.getId());

            bookResult.setOrderedCount(bestBook.getOrderedCount());
            bookResult.setCategory(bestBook.getCategory());

            return bookResult;
        } else {
            String category = categories[new Random().nextInt(categories.length)];
            results = getBooksByCategoryGBA(category);
            Book bookResult= results.get(new Random().nextInt(results.size()));

            return bookResult;
        }
    }

    @Override
    public Book[] searchBook(String query) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(query);
        JSONObject hasilJSON = new JSONObject();
        hasilJSON = googleBookAPI.searchBook();
        try {
            JSONArray resultItems = new JSONArray(hasilJSON.get("items").toString());
            Book[] bookResults = new Book[resultItems.length()];

            for(int i = 0; i < Math.min(10, resultItems.length()); i++) {
                String id = "";
                String title = "";
                String[] authors = {""};
                String category = "";
                String description = "";
                Integer price = 0;

                JSONObject book = new JSONObject(resultItems.get(i).toString());
                id = book.get("id").toString();

                JSONObject volumeInfo = new JSONObject(book.get("volumeInfo").toString());
                if (volumeInfo.has("title")) {
                    title = volumeInfo.get("title").toString();
                }

                if (volumeInfo.has("authors")) {
                    JSONArray authorsJSON = new JSONArray(volumeInfo.get("authors").toString());
                    authors = new String[authorsJSON.length()];
                    for(int j = 0; j < authorsJSON.length(); j++) {
                        authors[j] = authorsJSON.get(j).toString();
                    }
                }

                if (volumeInfo.has("categories")) {
                    JSONArray categoriesJSON = new JSONArray(volumeInfo.get("categories").toString());
                    for (int j = 0; j < categoriesJSON.length(); j++) {
                        category = categoriesJSON.get(j).toString();
                        break;
                    }
                }

                if (volumeInfo.has("description")) {
                    description = volumeInfo.get("description").toString();
                }

                if (book.has("saleInfo")) {
                    JSONObject saleInfo = new JSONObject(book.get("saleInfo").toString());
                    if (saleInfo.has("listPrice")) {
                        JSONObject listPrice = new JSONObject(saleInfo.get("listPrice").toString());
                        if (listPrice.has("amount")) {
                            price = listPrice.getInt("amount");
                        }
                    }
                }

                Book bookResult = new Book(id, title, authors, description, price, category);
                Book bookOnDb = this.getBookByIdDb(id);

                if (bookOnDb == null) {
                    int rowBook = this.addBook(id, price, category);
                }

                bookResults[i] = bookResult;
            }

            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return null;
    }
}
