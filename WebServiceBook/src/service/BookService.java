package service;

import javax.jws.WebMethod;
import javax.jws.WebService;
import javax.jws.soap.SOAPBinding;

import model.Book;

@WebService
@SOAPBinding(style = SOAPBinding.Style.RPC)
public interface BookService {
    @WebMethod
    public boolean addBook(Book p);

    @WebMethod
    public Book getBook(String id);

    @WebMethod
    public Book[] searchBook(String query);
}
