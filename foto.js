let currentSlide = 0;

        function showSlide(slideIndex, carouselId) {
            const carouselInner = document.querySelector(`#${carouselId} .carousel-inner`);
            const totalSlides = carouselInner.children.length;
            if (slideIndex >= totalSlides) {
                currentSlide = 0;
            } else if (slideIndex < 0) {
                currentSlide = totalSlides - 1;
            } else {
                currentSlide = slideIndex;
            }
            const offset = -currentSlide * 100;
            carouselInner.style.transform = `translateX(${offset}%)`;
        }

        function nextSlide(carouselId) {
            showSlide(currentSlide + 1, carouselId);
        }

        function prevSlide(carouselId) {
            showSlide(currentSlide - 1, carouselId);
        }