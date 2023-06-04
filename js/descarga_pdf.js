const botonDescarga = document.getElementById('botonDescarga');

botonDescarga.addEventListener('click', () =>{
    const div_cv = document.getElementById('contenedor_CV');

    html2canvas(div_cv).then(canvas => {
        const png = canvas.toDataURL('image/png');
        const pdf = new jsPDF();
        pdf.addImage(png, 'PNG', 0, 0);
        pdf.save('curriculum.pdf');
    });
});