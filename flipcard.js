/**
 * Catalog interactions (framework-free)
 * - Flip card toggle
 * - Code area tab switching
 *
 * Assumptions:
 * - Each component is wrapped in an element with class `.flipBox` (or add [data-flip-container]).
 * - Any flip button inside the wrapper has class `.flipToggle`.
 * - Code buttons have a `data-target="<panel-id>"` attribute.
 * - Code panels have IDs matching those targets and share a class `.codeArea`.
 *
 * This script uses container scoping so you can have multiple instances on a page
 * without relying on server-rendered IDs.
 */
(function () {
  "use strict";

  function hide(el) {
    el.style.display = "none";
  }
  function show(el) {
    el.style.display = "block";
  }

  document.addEventListener("DOMContentLoaded", function () {
    // Look for all instances on the page
    var containers = document.querySelectorAll(".flipBox, [data-flip-container]");
    if (!containers.length) return;

    containers.forEach(function (container) {
      // ----- Flip Toggle -----
      var flipBox = container; // treat the wrapper as the flipping element
      var flipButtons = container.querySelectorAll(".flipToggle, [data-flip-toggle]");

      flipButtons.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          flipBox.classList.toggle("flipped");
          // Update aria-pressed if present
          var pressed = btn.getAttribute("aria-pressed");
          if (pressed !== null) {
            btn.setAttribute("aria-pressed", String(!(pressed === "true")));
          }
        });
      });

      // ----- Code Area Tabs -----
      var codeButtons = container.querySelectorAll("[data-target]");
      if (!codeButtons.length) return; // No code buttons in this container

      // Collect panels either inside container or globally (id target)
      var panelMap = {};
      codeButtons.forEach(function (btn) {
        var targetId = btn.getAttribute("data-target");
        if (!targetId) return;
        var panel =
          container.querySelector("#" + CSS.escape(targetId)) ||
          document.getElementById(targetId);
        if (panel) {
          panelMap[targetId] = panel;
        }
      });

      // Helper to switch active panel
      function setActive(targetId) {
        // Hide all known panels & reset buttons
        Object.keys(panelMap).forEach(function (id) {
          hide(panelMap[id]);
        });
        codeButtons.forEach(function (b) {
          b.classList.remove("active");
          if (b.hasAttribute("aria-expanded")) {
            b.setAttribute("aria-expanded", "false");
          }
          if (b.hasAttribute("aria-selected")) {
            b.setAttribute("aria-selected", "false");
          }
        });

        // Show selected
        var activePanel = panelMap[targetId];
        if (activePanel) {
          show(activePanel);
        }

        // Mark triggering button active
        codeButtons.forEach(function (b) {
          if (b.getAttribute("data-target") === targetId) {
            b.classList.add("active");
            if (b.hasAttribute("aria-expanded")) {
              b.setAttribute("aria-expanded", "true");
            }
            if (b.hasAttribute("aria-selected")) {
              b.setAttribute("aria-selected", "true");
            }
          }
        });
      }

      // Wire up click handlers
      codeButtons.forEach(function (btn) {
        btn.addEventListener("click", function (e) {
          e.preventDefault();
          var targetId = btn.getAttribute("data-target");
          if (targetId && panelMap[targetId]) {
            setActive(targetId);
          }
        });
      });

      // Initialize: show the first available panel if any
      // Hide all panels first
      Object.keys(panelMap).forEach(function (id) {
        hide(panelMap[id]);
      });
      if (codeButtons.length) {
        var firstId = codeButtons[0].getAttribute("data-target");
        if (firstId && panelMap[firstId]) {
          setActive(firstId);
        }
      }
    });
  });
})();