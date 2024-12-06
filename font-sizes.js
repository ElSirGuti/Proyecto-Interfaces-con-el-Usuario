function applyFontSizes() {
    // Obtener los tamaños guardados del localStorage
    const labelSize = localStorage.getItem('labelSize') || '16';
    const h1Size = localStorage.getItem('h1Size') || '24';
    const h2Size = localStorage.getItem('h2Size') || '18';
    const h3Size = localStorage.getItem('h3Size') || '14';
    const pSize = localStorage.getItem('pSize') || '13';
    const sidebarSize = localStorage.getItem('sidebarSize') || '12';
    const buttonSize = localStorage.getItem('buttonSize') || '16';

    // Aplicar estilos a los elementos correspondientes
    document.querySelectorAll('h1').forEach(h1 => {
        h1.style.fontSize = `${h1Size}px`;
    });

    document.querySelectorAll('h2').forEach(h2 => {
        h2.style.fontSize = `${h2Size}px`;
    });

    document.querySelectorAll('h3').forEach(h3 => {
        h3.style.fontSize = `${h3Size}px`;
    });

    document.querySelectorAll('p').forEach(p => {
        p.style.fontSize = `${pSize}px`;
    });

    document.querySelectorAll('label').forEach(label => {
        label.style.fontSize = `${labelSize}px`;
    });

    document.querySelectorAll('.sidebar a').forEach(link => {
        link.style.fontSize = `${sidebarSize}px`;
    });

    document.querySelectorAll('.btn').forEach(button => {
        button.style.fontSize = `${buttonSize}px`;
    });
}

// Aplicar los tamaños cuando el DOM esté cargado
document.addEventListener('DOMContentLoaded', applyFontSizes);