export const useScrollAnimation = () => {
  const observeElements = () => {
    if (process.client) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add('visible')
            }
          })
        },
        {
          threshold: 0.1,
          rootMargin: '0px 0px -50px 0px'
        }
      )

      // Observar todos los elementos con la clase fade-in
      const elements = document.querySelectorAll('.fade-in')
      elements.forEach((el) => observer.observe(el))

      return observer
    }
  }

  return {
    observeElements
  }
}