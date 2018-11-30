package model;

import org.json.JSONObject;

import java.io.Serializable;
import java.util.ArrayList;
import java.util.List;

public class Book implements Serializable {
    private String id = "";
    private String title = "";
    private String[] authors = {""};
    private String description = "";
    private Integer price = 0;
    private List<String> categories = new ArrayList<>();
    private int orderedCount = 0;
    private String imgPath = "";

    public Book() {}

    public Book(String id, String title, String[] authors, String description, Integer price, List<String>  categories, int orderedCount, String imgPath) {
        this.id = id;
        this.title = title;
        this.authors = authors;
        this.description = description;
        this.price = price;
        this.categories = categories;
        this.orderedCount = orderedCount;
        this.imgPath = imgPath;
    }

    public Book(String id, int price, int orderedCount, List<String>  categories) {
        this.id = id;
        this.price = price;
        this.orderedCount = orderedCount;
        this.categories = categories;
    }

    public String getId() {
        return id;
    }

    public String getTitle() {
        return title;
    }

    public String[] getAuthors() {
        return authors;
    }

    public String getDescription() {
        return description;
    }

    public Integer getPrice() {
        return price;
    }

    public List<String>  getCategories() {
        return categories;
    }

    public int getOrderedCount() {
        return orderedCount;
    }

    public String getImgPath() {
        return imgPath;
    }
  
    public void setId(String id) {
        this.id = id;
    }

    public void setTitle(String title) {
        this.title = title;
    }

    public void setAuthors(String[] authors) {
        this.authors = authors;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    public void setPrice(Integer price) {
        this.price = price;
    }

    public void setCategories(List<String>  categories) {
        this.categories = categories;
    }

    public void setOrderedCount(int orderedCount) {
        this.orderedCount = orderedCount;
    }

    public void setImgPath(String imgPath) {
        this.imgPath = imgPath;
    }
}

