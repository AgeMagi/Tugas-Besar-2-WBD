package service;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

import model.Book;

import java.sql.ResultSet;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
    @WebMethod
    public int addBook(String id, int price);

    @WebMethod
    public Book getBook(String id);

    @WebMethod
    public Book[] searchBook(String query);
}
