import './bootstrap';
import CircularGalleryApp from '../../public/js/circular-gallery';

// Initialize gallery ketika DOM siap
document.addEventListener('DOMContentLoaded', () => {
    const galleryElement = document.getElementById('circular-gallery');

    if (galleryElement) {
        // Ambil data dari data attributes
        const items = JSON.parse(galleryElement.dataset.items || '[]');
        const bend = parseFloat(galleryElement.dataset.bend || '3');
        const textColor = galleryElement.dataset.textColor || '#ffffff';
        const borderRadius = parseFloat(galleryElement.dataset.borderRadius || '0.05');
        const font = galleryElement.dataset.font || 'bold 30px Inter';
        const scrollSpeed = parseFloat(galleryElement.dataset.scrollSpeed || '2');
        const scrollEase = parseFloat(galleryElement.dataset.scrollEase || '0.05');

        // Initialize gallery
        const gallery = new CircularGalleryApp(galleryElement, {
            items,
            bend,
            textColor,
            borderRadius,
            font,
            scrollSpeed,
            scrollEase
        });

        // Cleanup ketika navigasi (optional)
        window.addEventListener('beforeunload', () => {
            gallery.destroy();
        });
    }
});