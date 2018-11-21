package service;

import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.jws.WebService;

import model.Book;

@WebService()
public class BookServiceImpl implements  BookService {
    private static Map<String, Book> books = new HashMap<String, Book>();

    @Override
    public Book getBook(String id) {
        String[] cobaAuthors = {"Shinta"};
        Book cobaBook = new Book("123", "Laskar Pelangi", cobaAuthors, "Mantap bet mantap", 1234);

        return cobaBook;
    }

    @Override
    public boolean addBook(Book b) {
        if (books.get(b.getId()) != null) return false;
        books.put(b.getId(), b);
        return true;
    }

    @Override
    public Book[] searchBook(String query) {
        Set<String> ids = books.keySet();
        Book[] b = new Book[ids.size()];
        int i=0;
        for(String id : ids){
            b[i] = books.get(id);
            i++;
        }
        return b;
    }
}
