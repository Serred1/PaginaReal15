function bloquearNumeros(event) {
    let charCode = event.charCode ? event.charCode : event.keyCode;
    if (charCode >= 48 && charCode <= 57) {
        event.preventDefault();
    }
}
function deleteVideo(videoId) {
    Swal.fire({
        title: '¿Está seguro de que desea eliminar este video?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: "delete_video.php",
                type: "POST",
                data: {
                    video_id: videoId
                },
                success: function(response) {
                    if (response === "success") {
                        Swal.fire({
                            title: 'Video eliminado exitosamente',
                            icon: 'success',
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            title: 'Error al eliminar el video',
                            icon: 'error',
                        });
                    }
                }
            });
        }
    });
}