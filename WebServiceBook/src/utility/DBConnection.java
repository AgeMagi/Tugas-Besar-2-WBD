package utility;

import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.Map;

import config.devel;

public class DBConnection {
    private String host;
    private String username;
    private String password;
    private String dbName;
    private Connection conn;

    public DBConnection() {
        Map<String, String> attribute = devel.getAttribute();

        this.host = attribute.get("host");
        this.username = attribute.get("username");
        this.password = attribute.get("password");
        this.dbName = attribute.get("dbName");

        try {
            Class.forName("com.mysql.jdbc.Driver");
            Connection con = DriverManager.getConnection(String.format("jdbc:mysql://%s/%s",
                    this.host, this.dbName), this.username, this.password);

            this.conn = con;
        } catch (Exception err) {
            System.out.println(err);
        }
    }

    public ResultSet doGetQuery(String query) {
        try {
            Statement stmt = this.conn.createStatement();
            ResultSet rs = stmt.executeQuery(query);

            return rs;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    public int doPostQuery(String query) {
        try {
            Statement stmt = this.conn.createStatement();
            int result = stmt.executeUpdate(query);

            return result;
        } catch (Exception err) {
            System.out.println(err);
        }

        return 0;
    }
}
