let menuToggled = false;
const MOBILE_MENU = document.getElementById("mobile-menu");
const NAV = document.getElementById("sub-links");
const MOBILE_ICON = document.getElementById("menu-icon");
const MENU_TEXT = MOBILE_MENU.querySelector("p");
const PAGE_TITLE = document.title;

MOBILE_MENU.addEventListener("click", toggleMobileMenu, false);
MOBILE_MENU.addEventListener("mouseover", mobileMenuOnHover, false);
MOBILE_MENU.addEventListener("mouseout", mobileMenuOffHover, false);

function toggleMobileMenu() {
  if (menuToggled) {
    NAV.style.display = "none";
    MOBILE_ICON.style.backgroundImage = "url('images/burger.png')";
    MOBILE_ICON.style.width = "1.5rem";
    MOBILE_ICON.style.width = "1.5rem";
    menuToggled = false;
  } else {
    NAV.style.display = "block";
    MOBILE_ICON.style.backgroundImage = "url('images/x-icon.png')";
    MOBILE_ICON.style.width = "1.2rem";
    MOBILE_ICON.style.width = "1.2rem";
    menuToggled = true;
  }
}

function mobileMenuOnHover() {
  MENU_TEXT.style.color = "#5f5f5f";
  if (menuToggled) {
    MOBILE_ICON.style.backgroundImage = "url('images/x-icon-hover.png')";
  } else {
    MOBILE_ICON.style.backgroundImage = "url('images/burger-hover.png')";
  }
}

function mobileMenuOffHover() {
  MENU_TEXT.style.color = "#000000";
  if (menuToggled) {
    MOBILE_ICON.style.backgroundImage = "url('images/x-icon.png')";
  } else {
    MOBILE_ICON.style.backgroundImage = "url('images/burger.png')";
  }
}
