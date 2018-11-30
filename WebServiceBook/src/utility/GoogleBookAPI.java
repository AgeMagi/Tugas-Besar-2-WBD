package utility;

import org.json.JSONException;
import org.json.JSONObject;
import java.net.URL;
import java.net.URLEncoder;

import utility.HTTPRequest;

public class GoogleBookAPI {
    private String query;
    private String API_KEY = "AIzaSyBZmgEtwukg-N_eCzML5wQiKHcOKEOEu1Q";

    public GoogleBookAPI(String query) {
        this.query = query;
    }

    public JSONObject searchBook() {
        try {
            String query = URLEncoder.encode(this.query, "UTF-8");
            HTTPRequest googleBookAPIRequest = new HTTPRequest(String.format("https://www.googleapis.com/books/v1/volumes?q=intitle:%s&key=%s", query, this.API_KEY));
            String resultRequest = googleBookAPIRequest.doRequest("GET");
            JSONObject hasilJSON = new JSONObject(resultRequest);
            return hasilJSON;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    public JSONObject searchByCategory() {
        try {
            String query = URLEncoder.encode(this.query, "UTF-8");
            HTTPRequest googleBookAPIRequest = new HTTPRequest(String.format("https://www.googleapis.com/books/v1/volumes?q=subject:%s&key=%s", query, this.API_KEY));
            String resultRequest = googleBookAPIRequest.doRequest("GET");
            JSONObject hasilJSON = new JSONObject(resultRequest);
            return hasilJSON;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

    public JSONObject searchById() {
        try {
            String query = URLEncoder.encode(this.query, "UTF-8");
            HTTPRequest googleBookAPIRequest = new HTTPRequest(String.format("https://www.googleapis.com/books/v1/volumes/%s", query));
            String resultRequest = googleBookAPIRequest.doRequest("GET");
            JSONObject hasilJSON = new JSONObject(resultRequest);
            return hasilJSON;
        } catch (Exception err) {
            System.out.println(err);
        }

        return null;
    }

}
