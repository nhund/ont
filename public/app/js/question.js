$(document).ready(function() {
  //cau hoi trac nghiem
  $("#question-app-trac-nghiem .list-answer .answer").on("click", function(e) {
    var $this = $(this);
    $("#question-app-trac-nghiem .list-answer .answer").removeClass("checked");
    $this.find(".answer_radio").prop("checked", true);
    $this.addClass("checked");
    var form_data = $this.closest(".form_trac_nghiem").serializeArray();
    window.ReactNativeWebView.postMessage(JSON.stringify(form_data));
  });
  //comment
  $("#question-app-trac-nghiem .list-action .icon-comment").on(
    "click",
    function(e) {
      var $this = $(this);
      if ($this.hasClass("active")) {
        $this.removeClass("active");
        let data = {
          show_comment: false
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(data));
      } else {
        $this.addClass("active");
        let data = {
          show_comment: true
        };
        window.ReactNativeWebView.postMessage(JSON.stringify(data));
      }
    }
  );
  //bookmark
  $("#question-app-trac-nghiem .list-action .icon-bookmark").on(
    "click",
    function(e) {
      var $this = $(this);
      if ($this.hasClass("active")) {
        $this.removeClass("active");
      } else {
        $this.addClass("active");
      }
    }
  );
  //hien thi goi y
  $("#question-app-trac-nghiem .list-action .icon-sugess").on("click", function(
    e
  ) {
    var $this = $(this);
    if ($this.hasClass("active")) {
      $this.removeClass("active");
      $this
        .closest("#question-app-trac-nghiem")
        .find(".content .sugess_all")
        .hide();
    } else {
      $this.addClass("active");
      $this
        .closest("#question-app-trac-nghiem")
        .find(".content .sugess_all")
        .show();
    }
  });
  // setTimeout(function() {
  //   window.ReactNativeWebView.postMessage("Hello!");
  // }, 2000);
});
