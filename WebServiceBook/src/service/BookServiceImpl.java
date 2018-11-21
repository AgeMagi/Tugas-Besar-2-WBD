package service;

import java.util.HashMap;
import java.util.Map;
import java.util.Set;

import javax.jws.WebService;

import model.Book;

@WebService(endpointInterface = "service.BookService")
public class BookServiceImpl implements  BookService {
    private static Map<String, Book> books = new HashMap<String, Book>();

    @Override
    public boolean addBook(Book b) {
        if (books.get(b.getId()) != null) return false;
        books.put(b.getId(), b);
        return true;
    }

    @Override
    public Book getBook(String id) {
        return books.get(id);
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
