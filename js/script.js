document.addEventListener("DOMContentLoaded", () => {
  // Mobile Menu Toggle
  const menuToggle = document.querySelector(".menu-toggle")
  const navMenu = document.querySelector(".nav-menu")

  if (menuToggle) {
    menuToggle.addEventListener("click", () => {
      navMenu.classList.add("active")

      // Create close button if it doesn't exist
      if (!document.querySelector(".close-menu")) {
        const closeBtn = document.createElement("div")
        closeBtn.className = "close-menu"
        closeBtn.innerHTML = '<i class="fas fa-times"></i>'
        navMenu.appendChild(closeBtn)

        closeBtn.addEventListener("click", () => {
          navMenu.classList.remove("active")
        })
      }
    })
  }

  // Close menu when clicking outside
  document.addEventListener("click", (event) => {
    if (
      navMenu &&
      navMenu.classList.contains("active") &&
      !navMenu.contains(event.target) &&
      !menuToggle.contains(event.target)
    ) {
      navMenu.classList.remove("active")
    }
  })

  // Form validation
  const contactForm = document.getElementById("contactForm")
  if (contactForm) {
    contactForm.addEventListener("submit", (e) => {
      let valid = true
      const name = document.getElementById("name")
      const email = document.getElementById("email")
      const subject = document.getElementById("subject")
      const message = document.getElementById("message")

      // Simple validation
      if (name.value.trim() === "") {
        showError(name, "Name is required")
        valid = false
      } else {
        removeError(name)
      }

      if (email.value.trim() === "") {
        showError(email, "Email is required")
        valid = false
      } else if (!isValidEmail(email.value)) {
        showError(email, "Please enter a valid email")
        valid = false
      } else {
        removeError(email)
      }

      if (subject.value.trim() === "") {
        showError(subject, "Subject is required")
        valid = false
      } else {
        removeError(subject)
      }

      if (message.value.trim() === "") {
        showError(message, "Message is required")
        valid = false
      } else {
        removeError(message)
      }

      if (!valid) {
        e.preventDefault()
      }
    })
  }

  // Helper functions for form validation
  function showError(input, message) {
    const formGroup = input.parentElement
    const errorElement = formGroup.querySelector(".error-message") || document.createElement("div")

    errorElement.className = "error-message"
    errorElement.textContent = message

    if (!formGroup.querySelector(".error-message")) {
      formGroup.appendChild(errorElement)
    }

    input.classList.add("error-input")
  }

  function removeError(input) {
    const formGroup = input.parentElement
    const errorElement = formGroup.querySelector(".error-message")

    if (errorElement) {
      formGroup.removeChild(errorElement)
    }

    input.classList.remove("error-input")
  }

  function isValidEmail(email) {
    const re =
      /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
    return re.test(String(email).toLowerCase())
  }

  // Project filter
  const filterButtons = document.querySelectorAll(".filter-btn")
  const projectItems = document.querySelectorAll(".project-card")

  if (filterButtons.length > 0) {
    filterButtons.forEach((button) => {
      button.addEventListener("click", function () {
        // Remove active class from all buttons
        filterButtons.forEach((btn) => btn.classList.remove("active"))

        // Add active class to clicked button
        this.classList.add("active")

        const filterValue = this.getAttribute("data-filter")

        projectItems.forEach((item) => {
          if (filterValue === "all" || item.classList.contains(filterValue)) {
            item.style.display = "block"
          } else {
            item.style.display = "none"
          }
        })
      })
    })
  }

  // Smooth scroll for anchor links
  document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
      e.preventDefault()

      const targetId = this.getAttribute("href")
      if (targetId === "#") return

      const targetElement = document.querySelector(targetId)
      if (targetElement) {
        window.scrollTo({
          top: targetElement.offsetTop - 100,
          behavior: "smooth",
        })
      }
    })
  })
})
