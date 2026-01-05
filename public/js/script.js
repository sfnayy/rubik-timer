let timerDisplay = document.getElementById("timer");
let scrambleDisplay = document.getElementById("scramble");
let visualScrambleElement = document.getElementById("visualScramble");

let startTime;
let tInterval;
let running = false;
let isHolding = false;

// Variable global untuk menyimpan ID solve yang sedang dibuka
let currentSolveId = null;

window.onload = function () {
  generateScramble();
};

document.body.onkeydown = function (e) {
  if (e.code === "Space" || e.keyCode == 32) {
    e.preventDefault();
    if (
      document.querySelector(".modal.show") ||
      document.activeElement.tagName === "INPUT"
    )
      return;

    if (running) {
      stopTimer();
    } else {
      if (!isHolding) {
        timerDisplay.style.color = "#dc3545";
        isHolding = true;
      }
    }
  }
};

document.body.onkeyup = function (e) {
  if (e.code === "Space" || e.keyCode == 32) {
    e.preventDefault();
    if (
      !running &&
      isHolding &&
      !document.querySelector(".modal.show") &&
      document.activeElement.tagName !== "INPUT"
    ) {
      startTimer();
      isHolding = false;
    } else {
      timerDisplay.style.color = "#212529";
      isHolding = false;
    }
  }
};

function startTimer() {
  startTime = new Date().getTime();
  tInterval = setInterval(getShowTime, 10);
  running = true;
  timerDisplay.style.color = "#198754";
  timerDisplay.innerHTML = "00.00.00";
}

function stopTimer() {
  clearInterval(tInterval);
  running = false;
  timerDisplay.style.color = "#212529";

  let difference = new Date().getTime() - startTime;
  let scrambleText = scrambleDisplay.innerText;

  saveTime(difference, scrambleText);
  generateScramble();
}

function getShowTime() {
  let difference = new Date().getTime() - startTime;
  let min = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
  let sec = Math.floor((difference % (1000 * 60)) / 1000);
  let ms = Math.floor((difference % 1000) / 10);

  timerDisplay.innerHTML =
    (min < 10 ? "0" + min : min) +
    ":" +
    (sec < 10 ? "0" + sec : sec) +
    "." +
    (ms < 10 ? "0" + ms : ms);
}

function generateScramble() {
  const moves = ["R", "L", "U", "D", "F", "B"];
  const modifiers = ["", "'", "2"];
  let scramble = [];
  let lastMove = "";

  for (let i = 0; i < 20; i++) {
    let move = moves[Math.floor(Math.random() * moves.length)];
    while (move === lastMove)
      move = moves[Math.floor(Math.random() * moves.length)];
    scramble.push(
      move + modifiers[Math.floor(Math.random() * modifiers.length)]
    );
    lastMove = move;
  }

  let scrambleString = scramble.join(" ");
  if (scrambleDisplay) scrambleDisplay.innerText = scrambleString;
  if (visualScrambleElement) visualScrambleElement.alg = scrambleString;
}

function saveTime(timeMs, scramble) {
  fetch("index.php?url=solve/store", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ time_ms: timeMs, scramble: scramble }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        window.location.href = "index.php?show_last=1";
      }
    });
}

function showDetail(element) {
  let data = JSON.parse(element.getAttribute("data-detail"));
  currentSolveId = data.id;

  let displayTime = data.base_time;
  let badge = document.getElementById("modalPenaltyBadge");

  document.querySelectorAll(".btn-group .btn").forEach((btn) => {
    btn.classList.remove(
      "active",
      "btn-secondary",
      "btn-danger",
      "btn-success"
    );
    btn.classList.add("btn-outline-secondary");
  });

  if (data.penalty === "+2") {
    let parts = data.base_time.split(".");
    let sec = parseInt(parts[0]) + 2;
    displayTime = sec + "." + parts[1];
    badge.style.display = "inline-block";
    badge.innerText = "+2";
    badge.className = "badge bg-warning text-dark mb-2";
    document.getElementById("btnPlus2").classList.add("active", "btn-warning");
    document
      .getElementById("btnPlus2")
      .classList.remove("btn-outline-secondary");
  } else if (data.penalty === "DNF") {
    displayTime = "DNF";
    badge.style.display = "inline-block";
    badge.innerText = "Did Not Finish";
    badge.className = "badge bg-danger mb-2";
    document.getElementById("btnDNF").classList.add("active", "btn-danger");
    document.getElementById("btnDNF").classList.remove("btn-outline-secondary");
  } else {
    badge.style.display = "none";
    document.getElementById("btnOK").classList.add("active", "btn-success");
    document.getElementById("btnOK").classList.remove("btn-outline-secondary");
  }

  document.getElementById("modalTime").innerText = displayTime;
  document.getElementById("modalScramble").innerText = data.scramble;
  document.getElementById("modalDate").innerText = data.date;
  document.getElementById("modalSolveId").value = data.id;

  let modalVisual = document.getElementById("modalVisualScramble");
  if (modalVisual) modalVisual.alg = data.scramble;

  let detailDeleteBtn = document.getElementById("detailDeleteBtn");
  detailDeleteBtn.onclick = function () {
    let detailModalEl = document.getElementById("detailModal");
    let detailModal = bootstrap.Modal.getInstance(detailModalEl);
    detailModal.hide();
    confirmDelete(data.id);
  };

  let myModal = new bootstrap.Modal(document.getElementById("detailModal"));
  myModal.show();
}

function updatePenalty(status) {
  if (!currentSolveId) return;

  fetch("index.php?url=solve/update", {
    method: "POST",
    headers: { "Content-Type": "application/json" },
    body: JSON.stringify({ id: currentSolveId, penalty: status }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.status === "success") {
        location.reload();
      } else {
        alert("Gagal update status");
      }
    });
}

function confirmDelete(id) {
  let deleteBtn = document.getElementById("finalDeleteBtn");
  deleteBtn.href = "index.php?url=solve/delete/" + id;
  let deleteModal = new bootstrap.Modal(document.getElementById("deleteModal"));
  deleteModal.show();
}
