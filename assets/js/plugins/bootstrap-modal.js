// $('#rsvDetail').on('show.bs.modal', function (event) {
//     var button = $(event.relatedTarget) // Button that triggered the modal
//     var data = table.rows(indexes).data('dtatasan').toArray()
//     var rsv_id = data[0]
//     var rsv_nama = button.data('rsv_nama') // Extract info from data-* attributes
//     var rsv_tujuan = button.data('rsv_tujuan') // Extract info from data-* attributes
//     var rsv_keperluan = button.data('rsv_keperluan') // Extract info from data-* attributes
//     var rsv_anggota = button.data('rsv_anggota') // Extract info from data-* attributes
//     // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//     // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//     var modal = $(this)
//     modal.find('.modal-title').text('No. Reservasi : ')
//     modal.find('.modal-body input[name="rsv_id"]').val(rsv_id)
//     modal.find('.modal-body input[name="rsv_nama"]').val(rsv_nama)
//     modal.find('.modal-body input[name="rsv_tujuan"]').val(rsv_tujuan)
//     modal.find('.modal-body input[name="rsv_keperluan"]').val(rsv_keperluan)
//     modal.find('.modal-body textarea[name="rsv_anggota"]').val(rsv_anggota)
// })

$('#rsvBataldl').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget) // Button that triggered the modal
    var rsv_id = button.data('rsv_id') // Extract info from data-* attributes
    var modal = $(this)
    modal.find('.modal-body input[name="id"]').val(rsv_id)
})

