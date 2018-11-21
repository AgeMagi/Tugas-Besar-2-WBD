let urlString = window.location.href;
console.log(urlString);
if (urlString.includes("browse") || urlString.includes("results") || urlString.includes("book")){
    document.getElementById("menu_browse").style.backgroundColor = "#FF6029";
} else if (urlString.includes("history") || urlString.includes("/review")) {
    document.getElementById("menu_history").style.backgroundColor = "#FF6029";
} else if (urlString.includes("profile")) {
    document.getElementById("menu_profile").style.backgroundColor = "#FF6029";
}