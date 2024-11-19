document.querySelectorAll('.user-description-s').forEach(element => {
    const text = element.textContent.trim();
    const words = text.split(' ');

    if (words.length > 25) {
        const truncatedText = words.slice(0, 25).join(' ') + '...';
        element.textContent = truncatedText;
    }
});