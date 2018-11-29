
package service;

import utility.DBConnection;

import javax.xml.ws.Endpoint;
import java.sql.Connection;
import java.util.concurrent.ThreadLocalRandom;

public class SOAPPublisher {

    public static void main(String[] args) {
        Endpoint.publish("http://localhost:8888/ws/book", new BookServiceImpl());
    }

}
