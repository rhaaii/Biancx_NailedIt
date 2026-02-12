const buttons = document.querySelectorAll('.hero-buttons button');

buttons.forEach(button => {
    button.addEventListener('mousedown', () => {
        button.style.transform = 'scale(0.95)';
    });

    button.addEventListener('mouseup', () => {
        button.style.transform = 'scale(1.08)';
    });

    button.addEventListener('mouseleave', () => {
        button.style.transform = 'scale(1)';
    });
});

window.addEventListener('load', () => {
    const video = document.getElementById('bgVideo');
    if (video) {
        video.play().catch(error => {
            console.log("Autoplay was prevented. User interaction might be needed.");
        });
    }
});

const slayBtn = document.getElementById('slayBtn');

if (slayBtn) {
    slayBtn.addEventListener('click', () => {
        window.location.href = 'login.php';
    });
}

const aboutBtn = document.getElementById('aboutBtn');

if (aboutBtn) {
    aboutBtn.addEventListener('click', () => {
        window.location.href = 'aboutus.php'; 
    });
} 

const cntctBtn = document.getElementById('cntctBtn');

if (cntctBtn) {
    cntctBtn.addEventListener('click', () => {
        window.location.href = 'contact.php';
    });
}