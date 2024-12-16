$(document).ready(function() {
  const menuBtn = $(".menu-btn");
  const menuItems = $(".menu-items");
  const expandBtn = $(".expand-btn");

  // Hamburger toggle
  menuBtn.on("click", function() {
    menuBtn.toggleClass("open");
    menuItems.toggleClass("open");
  });

  // Mobile menu expand
  expandBtn.each(function() {
    $(this).on("click", function() {
      $(this).toggleClass("open");
    });
  });
});
