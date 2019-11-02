$(document).ready(function() {
  $("#question-app-trac-nghiem .list-answer .answer").on("click", function(e) {
    var $this = $(this);
    $("#question-app-trac-nghiem .list-answer .answer").removeClass("checked");
    $this.addClass("checked");
  });
  setTimeout(function() {
    window.ReactNativeWebView.postMessage("Hello!");
  }, 2000);
});
