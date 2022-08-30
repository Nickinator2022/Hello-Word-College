const PROGRAMS = document.getElementsByClassName("program");

window.addEventListener("load", adjustPrograms, false);
window.addEventListener("resize", adjustPrograms, true);

function adjustPrograms() {
  let maxHeight = getMaximumHeightOfPrograms();
  addMaxHeightToAllPrograms(maxHeight);
}

function getMaximumHeightOfPrograms() {
  let maxHeight = 0;
  let currentHeight = 0;

  for (let i = 0; i < PROGRAMS.length; i++) {
    PROGRAMS[i].style.height = "auto";
    currentHeight = PROGRAMS[i].clientHeight;
    if (currentHeight > maxHeight) {
      maxHeight = currentHeight;
    }
  }

  return maxHeight;
}

function addMaxHeightToAllPrograms(maxHeight) {
  for (let i = 0; i < PROGRAMS.length; i++) {
    PROGRAMS[i].style.height = maxHeight.toString() + "px";
  }
}
