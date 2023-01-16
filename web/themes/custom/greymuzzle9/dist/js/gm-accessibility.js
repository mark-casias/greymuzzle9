(function ($) {

  /**
   * Toggles a class of dyslexia on the body element when the
   * Dyslexia button is clicked so that fonts can be changed.
   */
  Drupal.behaviors.greymuzzleDyslexia = {
    attach: function (context, settings) {

      var dyslexic = false;

      // Set aria-checked on first page load.
      var attr = $('#dyslexia').attr('aria-checked');
      if (attr == undefined) {
        if ($.cookie("dyslexia")  == true) {
          $("#dyslexia").attr("aria-checked", "true");
        } else {
          $("#dyslexia").attr("aria-checked", "false");
        }
      }

      function dyslexiaSet() {
        $("body").toggleClass("dyslexia");
        $("#dyslexia").toggleClass("active");
        $("#dyslexia").attr("aria-checked", $("#dyslexia").attr("aria-checked") === "true" ? "false" : "true");
        if (dyslexic == false) {
          $.cookie("dyslexia", true, {path: "/", domain: window.location.host, expires: 1000});
          dyslexic = true;
        } else {
          $.cookie("dyslexia", null, {path: "/", domain: window.location.host});
          dyslexic = false;
        }
      }

      // Set a cookie so the dyslexia setting persists.
      if ($.cookie("dyslexia") != "undefined" && Boolean($.cookie("dyslexia")) == true  && $.cookie("dyslexia") != null) {
        dyslexiaSet()
      }

      $("#dyslexia").click(function () {
        if ($("body").hasClass("dyslexia")) {
          dyslexic = true
        }
        dyslexiaSet();
      });
    }
  };


  /**
   * Toggles a class of contrast on the body element when the
   * Contrast button is clicked so that fonts can be changed.
   */
  Drupal.behaviors.greymuzzleContrast = {
    attach: function (context, settings) {

      var contrasted = false;

      // Set aria-checked on first page load.
      var attr = $('#contrast').attr('aria-checked');
      if (attr == undefined) {
        if ($.cookie("contrast")  == true) {
          $("#contrast").attr("aria-checked", "true");
        } else {
          $("#contrast").attr("aria-checked", "false");
        }
      }

      function contrastSet() {
        $("body").toggleClass("contrast");
        $("#contrast").toggleClass("active");
        $("#contrast").attr("aria-checked", $("#contrast").attr("aria-checked") === "true" ? "false" : "true");
        if (contrasted == false) {
          $.cookie("contrast", true, {path: "/", domain: window.location.host, expires: 1000});
          contrasted = true;
        } else {
          $.cookie("contrast", null, {path: "/", domain: window.location.host});
          contrasted = false;
        }
      }

      // Set a cookie so the contrast setting persists.
      if ($.cookie("contrast") != "undefined" && Boolean($.cookie("contrast")) == true && $.cookie("contrast") != null) {
        contrastSet()
      }

      $("#contrast").click(function () {
        if ($("body").hasClass("contrast")) {
          contrasted = true
        }
        contrastSet()
      });
    }
  };

  // Add state to text resize links.
  // Add support for spacebar to activate resize links.
  Drupal.behaviors.greymuzzleResizeText = {
    attach: function (context, settings) {

      // Set aria-checked on first page load.
      $("a[role='radio']").each(function (index) {
        var attr = $(this).attr("aria-checked");
        if (attr == undefined) {
          $(this).attr("aria-checked", "false");
        }
      });

      var setRadio = function (t) {
        var currentlyChecked = t.parent().children("a[aria-checked='true']")[0];
        if (t.is(currentlyChecked)) {
          return;
        }
        toggleChecked(t);
        toggleChecked($(currentlyChecked));
      }

      var toggleChecked = function (t) {
        t.attr("aria-checked", t.attr("aria-checked") === "true" ? "false" : "true");
      }

      // Support spacebar press to activate text resize.
      var handleKeyEnter = function (t, key, handler, e) {
        if (key === 32) {
          handler(t);
          t.click();
          e.preventDefault();
        }
      }

      $("a[role='radio']").keydown(function(event) {
        var t = $(event.currentTarget);
        handleKeyEnter(t, event.which, setRadio, event);
      })
      .click(function(event) {
        var t = $(event.currentTarget);
        setRadio(t)
      });
    }
  };

})(jQuery);
