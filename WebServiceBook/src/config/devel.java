package config;

import java.util.HashMap;
import java.util.Map;

public class devel {
    public static Map<String, String> getAttribute() {
        Map<String, String> attribute = new HashMap<String, String>();

        attribute.put("host", "localhost:3306");
        attribute.put("username", "root");
        attribute.put("password", "");
        attribute.put("dbName", "webservice_book");

        return attribute;
    }
}
