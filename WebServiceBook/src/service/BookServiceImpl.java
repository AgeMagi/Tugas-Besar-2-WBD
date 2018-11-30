package service;

import java.awt.*;
import java.io.*;
import java.net.HttpURLConnection;
import java.nio.charset.StandardCharsets;
import java.sql.Connection;
import java.sql.ResultSet;
import java.util.*;
import java.util.List;
import java.util.concurrent.ThreadLocalRandom;
import java.net.URL;

import javax.jws.WebService;
import javax.xml.transform.Result;

import com.google.gson.Gson;
import model.Book;
import model.TransferStatus;
import org.json.JSONArray;
import org.json.JSONException;
import utility.GoogleBookAPI;
import org.json.JSONObject;
import utility.DBConnection;


@WebService()
public class BookServiceImpl implements  BookService {
    public int saveCategoryBook(String id, String category) {
        DBConnection bookDb = new DBConnection();
        ResultSet resultSet = bookDb.doGetQuery(String.format("SELECT * FROM category_book WHERE book_id=\"%s\" " +
                "                                       AND category=\"%s\"", id, category));
        int result = 0;

        try {
            if (!resultSet.next()) {
                result = bookDb.doPostQuery(String.format("INSERT INTO category_book(book_id, category) " +
                        "                                           VALUES(\"%s\", \"%s\")", id, category));
            }
        } catch (Exception err) {
            System.out.println(err);
        }

        return result;
    }

    public List<String> getCategoriesBook(String id) {
        DBConnection bookDb = new DBConnection();
        List<String> categories = new ArrayList<>();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM category_book WHERE book_id=\"%s\"", id));
        try {
            while(result.next()) {
                categories.add(result.getString("category"));
            }
        } catch (Exception err) {
            System.out.println(err);
        }

        return categories;
    }

    public int addBook(String id, int price, List<String> categories) {
        DBConnection bookDb = new DBConnection();
        int result = bookDb.doPostQuery(String.format("INSERT INTO book(book_id, price)" +
                "                                      VALUES(\"%s\", %d)", id, price));

        for(int i = 0; i < categories.size(); i++) {
            result = this.saveCategoryBook(id, categories.get(i));
        }

        return result;
    }


    public Book getBookByIdDb(String id) {
        DBConnection bookDb = new DBConnection();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM book WHERE book_id = \"%s\"", id));

        try {
            while(result.next()) {
                String book_id = result.getString("book_id");
                int price = result.getInt("price");
                Integer orderedCount = this.getOrderedCount(book_id);
                List<String> categories = getCategoriesBook(book_id);

                Book resultBook = new Book(book_id, price, orderedCount, categories);

                return resultBook;
            }
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

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

    public List<Book> getBooksByCategoryDb(String category) {
        DBConnection bookDb = new DBConnection();
        ResultSet result = bookDb.doGetQuery(String.format("SELECT * FROM category_book WHERE category LIKE \"%s\"", category));

        List<Book> bookResults = new ArrayList<>();

        try {
            while(result.next()) {
                String book_id = result.getString("book_id");
                Book bookResult = getBookByIdDb(book_id);

                bookResults.add(bookResult);
            }

            return bookResults;
        } catch (Exception err) {
            System.out.println(err);
        }

        return bookResults;
    }

    public List<Book> getBooksByCategoryGBA(String category) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(category);
        JSONObject hasilJSON = new JSONObject();
        hasilJSON = googleBookAPI.searchByCategory();
        List<Book> bookResults = new ArrayList<>();
        try {
            JSONArray resultItems = new JSONArray(hasilJSON.get("items").toString());

            for(int i = 0; i < Math.min(10, resultItems.length()); i++) {
                String id = "";
                String title = "";
                String[] authors = {""};
                List<String> categories = new ArrayList<>();
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
                        categories.add(categoriesJSON.get(j).toString());
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

                    int rowBook = this.addBook(id, price, categories);
                } else {
                    price = bookOnDb.getPrice();
                    ordered_count = bookOnDb.getOrderedCount();
                }


                Book bookResult = new Book(id, title, authors, description, price, categories, ordered_count, imgPath);

                bookResults.add(bookResult);
            }
            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return bookResults;
    }

    public Book getBookByIdGBA(String id) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(id);
        JSONObject book;
        book = googleBookAPI.searchById();
        try {
            String book_id = "";
            String title = "";
            String[] authors = {""};
            List<String> categories = new ArrayList<>();
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
                    categories.add(categoriesJSON.get(j).toString());
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
                if (price == 0) {
                    price = bookOnDb.getPrice();
                }
                if (ordered_count == 0) {
                    ordered_count = bookOnDb.getOrderedCount();
                }
                for(int j = 0; j < categories.size(); j++) {
                    this.saveCategoryBook(book_id, categories.get(j));
                }
            } else {
                if (price == 0) {
                    int not_for_sale = ThreadLocalRandom.current().nextInt(0, 2);
                    if (not_for_sale == 1) {
                        price = ThreadLocalRandom.current().nextInt(10000, 100000);
                    } else {
                        price = 0;
                    }
                }

                this.addBook(book_id, price, categories);
            }

            Book bookResult = new Book(book_id, title, authors, description, price, categories, ordered_count, imgPath);

            return bookResult;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    @Override
    public Book getBookDetail(String id) {
        Book bookResult = this.getBookByIdGBA(id);

        if (bookResult != null) {
            return bookResult;
        }
        return new Book();
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
                return t1.getOrderedCount() - book.getOrderedCount();
            }
        });

        if (results.size() != 0) {
            Book bestBook = results.get(0);
            Book bookResult = this.getBookByIdGBA(bestBook.getId());

            return bookResult;
        } else {
            String category = categories[new Random().nextInt(categories.length)];
            results = getBooksByCategoryGBA(category);
            Book bookResult= results.get(new Random().nextInt(results.size()));

            return bookResult;
        }
    }

    @Override
    public List<Book> searchBook(String query) {
        GoogleBookAPI googleBookAPI = new GoogleBookAPI(query);
        JSONObject hasilJSON = new JSONObject();
        hasilJSON = googleBookAPI.searchBook();
        List<Book> bookResults = new ArrayList<>();
        try {
            JSONArray resultItems = new JSONArray(hasilJSON.get("items").toString());

            for(int i = 0; i < Math.min(10, resultItems.length()); i++) {
                String id = "";
                String title = "";
                String[] authors = {""};
                List<String> categories = new ArrayList<>();
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
                        categories.add(categoriesJSON.get(j).toString());
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
                            price = 0;
                        } else {
                            price = ThreadLocalRandom.current().nextInt(10000, 100000);
                        }
                    }

                    int rowBook = this.addBook(id, price, categories);
                } else {
                    price = bookOnDb.getPrice();
                    ordered_count = bookOnDb.getOrderedCount();
                }

                Book bookResult = new Book(id, title, authors, description, price, categories, ordered_count, imgPath);

                bookResults.add(bookResult);
            }

            return bookResults;
        } catch (JSONException err) {
            System.out.println(err);
        }

        return bookResults;
    }

    public TransferStatus checkTransfer(String senderCard, Integer price ){
        String urlParameters ="sender_card_number="+ senderCard + "&amount=" + price;

        String url = "http://localhost:8000/transaction";
        HttpURLConnection connection;
        TransferStatus transferStatus = new TransferStatus();

        try {
            connection = (HttpURLConnection) new URL(url).openConnection();
            connection.setDoOutput(true); //triggered post
            connection.setRequestProperty("Content-Type","application/x-www-form-urlencoded;charset=UTF-8");
            connection.setRequestProperty("Accept-Charset",urlParameters);
            connection.setRequestMethod("POST");

            OutputStream output = connection.getOutputStream();
            output.write(urlParameters.getBytes(StandardCharsets.UTF_8));


            InputStream response = connection.getInputStream();
            BufferedReader br = new BufferedReader(new InputStreamReader(response));
            StringBuilder sb = new StringBuilder();
            String line;
            while ((line=br.readLine())!=null){
                sb.append(line + "\n");
            }
            br.close();

            Gson gson = new Gson();
            String parsedString = sb.toString();

            transferStatus = gson.fromJson(parsedString, TransferStatus.class);
        } catch (IOException e) {
            e.printStackTrace();
        }

        return transferStatus;

    }

    @Override
    public TransferStatus buyBook(String id, Integer counts, String sender){
        Integer countOrder = getOrderedCount(id);
        Book bookOnDb = this.getBookByIdDb(id);
        Integer totalPrice = (bookOnDb.getPrice() * counts);
        DBConnection bookDb = new DBConnection();

        String urlParameter =  "sender_card_number=" + sender + "&amount=";
        String url = "http://localhost:8000/transaction";

        TransferStatus transferStatus = checkTransfer(sender,totalPrice);
        try {
            if (transferStatus.status == 0){
                bookDb.doPostQuery(String.format("INSERT INTO ordered_book ( book_id, sender_card_number, ordered_count) VALUES (\"%s\",\"%s\",%d)",id,sender,counts));
            }
        }
        catch (Exception e) {
            e.printStackTrace();
        }

        return transferStatus;
    }
}
