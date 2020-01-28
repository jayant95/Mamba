let addHeart = (parentID) => {

    // Retrieve the heart button div through the parents children
    let heartClass = parentID.children[0].children[0].children[1];
    let numHeartsHTML = heartClass.getElementsByTagName('p')[0].innerHTML;
    
    // Convert the HTML string to number and increment
    let numHearts = Number(numHeartsHTML) + 1;

    // Set the new number back to the HTML
    heartClass.getElementsByTagName('p')[0].innerHTML = numHearts;

    let heartButton = parentID.children[2].children[0];
    // Remove onclick listener from heart button
    heartButton.onclick = null;
    heartButton.removeChild(heartButton.children[0]);
    heartButton.children[0].style.marginLeft = 0;
    heartButton.children[0].src = "img/heart_clicked.png";
    heartButton.classList.add("clicked");
    
    sendXHR("GET", "includes/updateHearts.php?status=success&hearts=" + numHearts + "&id=" + parentID.id, null, function(response) {
        console.log(response);
    })
    
}

function sendXHR(type, url, data, callback) {
    newXHR = new XMLHttpRequest() || new window.ActiveXObject("Microsoft.XMLHTTP");
    newXHR.open(type, url, true); // Use async = true to avoid bad user experience for waiting a Sychronous request that might block the UI.
    newXHR.send(data);
    newXHR.onreadystatechange = function() {
      if (this.status === 200 && this.readyState === 4) {
        callback(this.response); // Callback function to process the response.
      }
    };
  }
