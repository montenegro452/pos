(function ($) {
  "use strict";
  $(function () {
    var body = $("body");
    var contentWrapper = $(".content-wrapper");
    var scroller = $(".container-scroller");
    var footer = $(".footer");
    var sidebar = $(".sidebar");

    //Add active class to nav-link based on url dynamically
    //Active class can be hard coded directly in html file also as required

    function addActiveClass(element) {
      // Normalize link href and get path segments
      var href = (element.attr("href") || "").split("?")[0].replace(/\/$/, "");
      var parts = href.split("/").filter(function (p) {
        return p.length > 0;
      });
      var linkLast = parts.length ? parts[parts.length - 1] : "";
      var linkController = parts.length > 1 ? parts[parts.length - 2] : "";

      if (current === "") {
        // root url -> match index or empty last segment
        if (linkLast === "" || linkLast === "index.html") {
          element.parents(".nav-item").last().addClass("active");
          if (element.parents(".sub-menu").length) {
            element.closest(".collapse").addClass("show");
            element.addClass("active");
          }
        }
      } else {
        // Mark active only when controller AND last segment match
        // This prevents 'cajas/nuevo' from matching 'compras/nuevo'
        if (linkLast === current && linkController === currentController) {
          element.parents(".nav-item").last().addClass("active");
          if (element.parents(".sub-menu").length) {
            element.closest(".collapse").addClass("show");
            element.addClass("active");
          }
          if (element.parents(".submenu-item").length) {
            element.addClass("active");
          }
        }
        // Also match if just the controller matches (for index pages)
        // e.g., 'cajas' in URL matches 'cajas' link
        if (linkLast === currentController && linkController === "") {
          element.parents(".nav-item").last().addClass("active");
          if (element.parents(".sub-menu").length) {
            element.closest(".collapse").addClass("show");
            element.addClass("active");
          }
        }
      }
    }

    var pathParts = location.pathname.split("/").filter(function (p) {
      return p.length > 0;
    });
    var current = pathParts.length
      ? pathParts[pathParts.length - 1].replace(/^\/|\/$/g, "")
      : "";
    var currentController =
      pathParts.length > 1 ? pathParts[pathParts.length - 2] : "";
    $(".nav li a", sidebar).each(function () {
      var $this = $(this);
      addActiveClass($this);
    });

    //Close other submenu in sidebar on opening any

    sidebar.on("show.bs.collapse", ".collapse", function () {
      sidebar.find(".collapse.show").collapse("hide");
    });

    //Change sidebar

    $('[data-toggle="minimize"]').on("click", function () {
      body.toggleClass("sidebar-icon-only");
    });

    //checkbox and radios
    $(".form-check label,.form-radio label").append(
      '<i class="input-helper"></i>',
    );
  });
})(jQuery);
