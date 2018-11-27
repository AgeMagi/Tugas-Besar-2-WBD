
package service;

import utility.DBConnection;

import javax.xml.ws.Endpoint;
import java.sql.Connection;

public class SOAPPublisher {

    public static void main(String[] args) {
        Endpoint.publish("http://localhost:8888/ws/book", new BookServiceImpl());
    }

}
