document.addEventListener("DOMContentLoaded", function () {
  const observerOptions = {
    threshold: 0.4 
  };

  function handleIntersection(entries, observer) {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        
        const children = entry.target.querySelectorAll('h1');
        children.forEach(h => h.classList.add('animate-in'));
        observer.unobserve(entry.target); 
      }
    });
  }

  const observer = new IntersectionObserver(handleIntersection, observerOptions);

  
  const titulo = document.querySelector('.titulo');
  const vipText = document.querySelector('.vip-text');
  const righttitle = document.querySelector('.right-title');

  if (titulo) observer.observe(titulo);
  if (vipText) observer.observe(vipText);
  if (righttitle) observer.observe(righttitle);




  const leftButton = document.querySelector('.left-button');
  const centerButton = document.querySelector('.center-button');
  const rightButton = document.querySelector('.right-button');

  if (leftButton) {
    setTimeout(() => {
      leftButton.style.animation = "slideFromLeft 0.8s ease forwards";
    }, 200);
  }

  if (centerButton) {
    setTimeout(() => {
      centerButton.style.animation = "dropFromTop 0.8s ease forwards";
    }, 400);
  }

  if (rightButton) {
    setTimeout(() => {
      rightButton.style.animation = "slideFromRight 0.8s ease forwards";
    }, 600);
  }

    const divisao = document.querySelector('.divisao');

  const observer2 = new IntersectionObserver(entries => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const [imgLeft, imgRight] = divisao.querySelectorAll('img');

        if (imgLeft) {
          imgLeft.style.animation = "slideInLeftBar 1s ease-out forwards";
        }

        if (imgRight) {
          imgRight.style.animation = "slideInRightBar 1s ease-out forwards";
        }

        observer2.unobserve(divisao); 
      }
    });
  }, {
    threshold: 1
  });

  if (divisao) {
    observer2.observe(divisao);
  }







    if (window.innerWidth >= 768) {
        fetch('eventos_ajax.php')
        .then(res => res.json())
        .then(data => {
            const container = document.querySelector('.cards-container');
            container.innerHTML = ''; 
            data.forEach(evento => {
            const card = document.createElement('div');
            card.className = "col-12 col-sm-6 col-lg-3 d-flex justify-content-center";
            card.innerHTML = `
                <div class="destaque-card">
                <div class="card-bg" style="background-image: url('uploads/eventos/${evento.imagem_card}');"></div>
                <div class="card-content">
                    <div class="event-date">
                    <?= date("d–m", strtotime($evento['data_inicio'])) . ' – ' . date("d-m", strtotime($evento['data_fim'])) ?>
                    </div>
                    <div class="event-title">${evento.titulo}</div>
                    <div class="dj1-image-wrapper">
                    <img src="uploads/Eventos/${evento.imagem_banner}" alt="DJ" />
                    </div>
                    <div class="event-lineup">${evento.lineup.replaceAll(';', '<br>')}</div>
                </div>
                <a href="eventos2.php?id=${evento.id}" class="btn mini-button card-button">+ INFO</a>
                </div>
            `;
            container.appendChild(card);
            });
        });
    }
});




