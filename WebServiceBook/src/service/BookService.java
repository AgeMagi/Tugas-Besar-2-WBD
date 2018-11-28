package service;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

import model.Book;

import java.sql.ResultSet;
import java.util.List;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
    @WebMethod
    Book getBookByIdGBA(String id);

    @WebMethod
    public Book[] searchBook(String query);

    @WebMethod
    public Book getBookByIdDb(String id);

    @WebMethod
    public Book recommendationBooks(String[] categories);
}
