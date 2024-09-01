const nav = document.querySelector('.topnav');

    window.addEventListener('scroll', function(){
        nav.classList.toggle('active', this.window.scrollY >100)
    })