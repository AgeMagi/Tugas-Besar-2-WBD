package model;

import java.io.Serializable;

public class Book implements Serializable {
    private String id = "";
    private String title = "";
    private String[] authors;
    private String description;
    private Integer price;
    private String category;
    private int orderedCount;
    private String imgPath;

    public Book() {}

    public Book(String id, String title, String[] authors, String description, Integer price, String category, int orderedCount, String imgPath) {
        this.id = id;
        this.title = title;
        this.authors = authors;
        this.description = description;
        this.price = price;
        this.category = category;
        this.orderedCount = orderedCount;
        this.imgPath = imgPath;
    }

    public Book(String id, int price, int orderedCount, String category) {
        this.id = id;
        this.price = price;
        this.orderedCount = orderedCount;
        this.category = category;
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

    public String getCategory() {
        return category;
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

    public void setCategory(String category) {
        this.category = category;
    }

    public void setOrderedCount(int orderedCount) {
        this.orderedCount = orderedCount;
    }

    public void setImgPath(String imgPath) {
        this.imgPath = imgPath;
    }
}

