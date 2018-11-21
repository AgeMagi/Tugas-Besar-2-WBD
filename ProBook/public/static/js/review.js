var rating = 1;

var stars = [];
for(i = 0; i < 5; i++) {
    let star = document.getElementById(`star-${i}`);
    stars.push(star);
}

var ratingInput = document.getElementById("rating");

const onRatingMouseOver = function() {
    const key = this.getAttribute("key")

    for(i = 0; i < parseInt(key) + 1; i++) {
        stars[i].src="/static/img/full_star.png";
    }
    for(i = parseInt(key) + 1; i< 5; i++) {
        stars[i].src="/static/img/empty_star.png";
    }
}

const onRatingMouseOut = function() {
    for (i = 0; i < rating; i++) {
        stars[i].src="/static/img/full_star.png";
    }
    for(i = rating; i < 5; i++) {
        stars[i].src="/static/img/empty_star.png";
    }
}

const onRatingClick = function() {
    if (rating == parseInt(this.getAttribute("key")) + 1) {
        rating = 1;
    } else {
        rating = parseInt(this.getAttribute("key")) + 1;
    }
    ratingInput.value = rating;
}

window.onload = function() {
    for (i = 0; i < 5; i++) {
        stars[i].onmouseover = onRatingMouseOver;
        stars[i].onmouseout = onRatingMouseOut;
        stars[i].onclick = onRatingClick;
    }
}