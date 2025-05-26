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

  // Scroll Animation Observer
  const observerOptions = {
    threshold: 0.4,
    rootMargin: "0px 0px -50px 0px",
  }

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add("animate")
        // Optional: Stop observing once animated
        observer.unobserve(entry.target)
      }
    })
  }, observerOptions)

  // Add scroll animations to cards
  const animatedElements = document.querySelectorAll(
    ".service-card, .project-card, .partner-logo, .partner-card, .highlight-card, .benefit-card, .value-card, .testimonial, .value-item, .col, .fade-in",
  )

  animatedElements.forEach((element) => {
    observer.observe(element)
  })

  // Add fade-in class to section titles and other elements
  const sectionTitles = document.querySelectorAll(".section-title")
  sectionTitles.forEach((title) => {
    title.classList.add("fade-in")
    observer.observe(title)
  })

  // Add fade-in to about content
  const aboutContent = document.querySelector(".about-content")
  if (aboutContent) {
    aboutContent.classList.add("fade-in")
    observer.observe(aboutContent)
  }

  // Add fade-in to hero content
  const heroContent = document.querySelector(".hero-content")
  if (heroContent) {
    heroContent.classList.add("fade-in")
    observer.observe(heroContent)
  }
})

// Alternative scroll animation function for older browsers
function initScrollAnimations() {
  const elements = document.querySelectorAll(".service-card, .project-card, .partner-logo, .partner-card, .highlight-card, .benefit-card, .testimonial, .col, .value-card, .value-item")

  function checkScroll() {
    elements.forEach((element) => {
      const elementTop = element.getBoundingClientRect().top
      const elementVisible = 150

      if (elementTop < window.innerHeight - elementVisible) {
        element.classList.add("animate")
      }
    })
  }

  // Fallback for browsers that don't support IntersectionObserver
  if (!window.IntersectionObserver) {
    window.addEventListener("scroll", checkScroll)
    checkScroll() // Check on load
  }
}

// Initialize fallback animations
initScrollAnimations()
