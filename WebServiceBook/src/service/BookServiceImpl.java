package service;

import java.net.HttpURLConnection;
import java.sql.Connection;
import java.sql.ResultSet;
import java.util.*;
import java.util.concurrent.ThreadLocalRandom;

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
     public Integer getOrderedCount(String id) {
         DBConnection bookDb = new DBConnection();
         Integer ordered_count = 0;
         ResultSet result = bookDb.doGetQuery(String.format("SELECT SUM(ordered_count) AS ordered_count FROM ordered_book WHERE book_id=\"%s\"", id));
         try {
             while(result.next()) {
                 ordered_count = result.getInt("ordered_count");

                 return ordered_count;
             }
         } catch (Exception err) {
             System.out.println(err);
         }

         return ordered_count;
     }

    public Book getBookByIdDb(String id) {
        DBConnection bookDb = new DBConnection();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM book WHERE book_id = \"%s\"", id));

        try {
            while(result.next()) {
                String book_id = result.getString("book_id");
                int price = result.getInt("price");
                String category = result.getString("category");
                Integer orderedCount = this.getOrderedCount(book_id);
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
        int result = bookDb.doPostQuery(String.format("INSERT INTO book(book_id, price, category)" +
            "                                      VALUES(\"%s\", %d, \"%s\")", id, price, category));

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
                Integer ordered_count = 0;
                String imgPath = "";

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

                if (volumeInfo.has("imageLinks")) {
                    JSONObject imageLinks = new JSONObject(volumeInfo.get("imageLinks").toString());
                    if (imageLinks.has("smallThumbnail")) {
                        imgPath = imageLinks.get("smallThumbnail").toString();
                    } else if (imageLinks.has("thumbnail")) {
                        imgPath = imageLinks.get("thumbnail").toString();
                    }
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

                Book bookOnDb = this.getBookByIdDb(id);

                if (bookOnDb == null) {
                    if (price == 0) {
                        int not_for_sale = ThreadLocalRandom.current().nextInt(0, 2);
                        if (not_for_sale == 1) {
                            price = ThreadLocalRandom.current().nextInt(10000, 100000);
                        } else {
                            price = 0;
                        }
                    }

                    int rowBook = this.addBook(id, price, category_result);
                } else {
                    price = bookOnDb.getPrice();
                    ordered_count = bookOnDb.getOrderedCount();
                }


                Book bookResult = new Book(id, title, authors, description, price, category_result, ordered_count, imgPath);


                bookResults.add(bookResult);
            }

            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return null;
    }

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
            Integer ordered_count = 0;
            String imgPath = "";

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

            if (volumeInfo.has("imageLinks")) {
                JSONObject imageLinks = new JSONObject(volumeInfo.get("imageLinks").toString());
                if (imageLinks.has("smallThumbnail")) {
                    imgPath = imageLinks.get("smallThumbnail").toString();
                } else if (imageLinks.has("thumbnail")) {
                    imgPath = imageLinks.get("thumbnail").toString();
                }
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

            Book bookOnDb = this.getBookByIdDb(book_id);
            if (bookOnDb != null) {
                if (category == "") {
                    category = bookOnDb.getCategory();
                }
                if (price == 0) {
                    price = bookOnDb.getPrice();
                }
                if (ordered_count == 0) {
                    ordered_count = bookOnDb.getOrderedCount();
                }
            }

            Book bookResult = new Book(book_id, title, authors, description, price, category, ordered_count, imgPath);

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
                String categoryDb = result.getString("category");
                Integer ordered_count = this.getOrderedCount(book_id);

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
    public Book getBookDetail(String id) {
        Book bookOnDb = this.getBookByIdDb(id);
        if (bookOnDb != null) {
            Book bookResult = this.getBookByIdGBA(id);
            return bookResult;
        }

        return null;
    }

    @Override
    public Book recommendationBook(String[] categories) {
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
                Integer ordered_count = 0;
                String imgPath = "";

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

                if (volumeInfo.has("imageLinks")) {
                    JSONObject imageLinks = new JSONObject(volumeInfo.get("imageLinks").toString());
                    if (imageLinks.has("smallThumbnail")) {
                        imgPath = imageLinks.get("smallThumbnail").toString();
                    } else if (imageLinks.has("thumbnail")) {
                        imgPath = imageLinks.get("thumbnail").toString();
                    }
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
                Book bookOnDb = this.getBookByIdDb(id);

                if (bookOnDb == null) {
                    if (price == 0) {
                        int not_for_sale = ThreadLocalRandom.current().nextInt(0, 2);
                        if (not_for_sale == 1) {
                            price = ThreadLocalRandom.current().nextInt(10000, 100000);
                        } else {
                            price = 0;
                        }
                    }

                    int rowBook = this.addBook(id, price, category);
                } else {
                    price = bookOnDb.getPrice();
                    ordered_count = bookOnDb.getOrderedCount();
                }

                Book bookResult = new Book(id, title, authors, description, price, category, ordered_count, imgPath);

                bookResults[i] = bookResult;
            }

            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return null;
    }

    @Override
    public JSONObject checkTransfer(String senderCard, Integer price ){
        String urlParameters ="sender_card_number"= senderCard + "&amount=" + price;
        String url = "http://localhost:8000/transacton";
        HttpURLConnection connectionl
        connection = (HttpURLConnection) new URL(url).openCon
    }

    @Override
    public Book buyBook(String id, Integer counts, String sender ){


        DBConnection bookDb = new DBConnection();

        Integer countOrder = getOrderedCount(id);
        Book bookOnDb = this.getBookByIdDb(id);
        Integer price = bookOnDb.getPrice();

        String urlParameter =  "sender_card_number=" + sender + "&amount=";
        String url = "http://localhost:8000/transaction";

        //anggap aja hasil = hasil

        try {
            //ambil ke nodejs{messa ad, data: 'status'}

            if (data["status"]== 0){
                ResultSet result =
                        bookDb.doGetQuery(String.format("INSERT INTO ordered_book ( book_id, sender_card_number, ordered_count) VALUES (\"%s\",\"%s\",%d) WHERE book_id = \"%s\"",id,sender,counts, id));
                return
            }

        }
        catch () {
        }

        return null;
    }
}
