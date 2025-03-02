document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("post-reply").addEventListener("click", postReply);
});

// Function to Post a Reply
function postReply() {
    let replyText = document.getElementById("reply-input").value.trim();
    if (replyText === "") {
        alert("Reply cannot be empty!");
        return;
    }

    let repliesList = document.getElementById("replies-list");
    
    // Create Reply Element
    let replyItem = document.createElement("li");
    replyItem.classList.add("reply");

    replyItem.innerHTML = `
        <p class="reply-content">${replyText}</p>
        <span class="reply-author">Posted by <strong>User123</strong></span>
        <button class="reply-button">Reply</button>
    `;

    repliesList.appendChild(replyItem);

    // Clear Input Field
    document.getElementById("reply-input").value = "";

    // Add Event Listener for Nested Replies
    replyItem.querySelector(".reply-button").addEventListener("click", function () {
        createNestedReply(replyItem);
    });
}

// Function to Handle Nested Replies
function createNestedReply(parentReply) {
    let replyText = prompt("Write your reply:");
    if (!replyText) return;

    let nestedReply = document.createElement("div");
    nestedReply.classList.add("nested-reply");
    nestedReply.innerHTML = `<p>${replyText}</p><span class="reply-author">Posted by <strong>User123</strong></span>`;

    parentReply.appendChild(nestedReply);
}