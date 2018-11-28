package model;

import java.io.Serializable;

public class Book implements Serializable {
    private String id;
    private String title;
    private String[] authors;
    private String description;
    private Integer price;
    private String[] categories;

    public Book() {}

    public Book(String id, String title, String[] authors, String description, Integer price, String[] categories) {
        this.id = id;
        this.title = title;
        this.authors = authors;
        this.description = description;
        this.price = price;
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

    public String[] getCategories() {
        return categories;
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

    public void setCategories(String[] categories) {
        this.categories = categories;
    }
}

