<?= view('head') ?>
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Cari harga barang</h1>
    <form class="d-flex col-lg-4" onsubmit="return false">
          <input onkeyup="Scari();" id="cari" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    
    <div class="row d-flex col-lg-12 p-2" id="hasil-cari">
      <div>
      </div> 
  </div>
</main>
<script>
  function reverseString(str) {
    return str.split("").reverse().join("");
}
// reverseString("hello");
  function pricesp(price){
    price = reverseString(price);
    l = price.length;
    r = '';
    i2 = 1
    for (let i = 0; i < l; i++) {
      if (i2>3) {
        r = r+'.';
        i2 = 1;
      }
      i2++;
      r = r+price[i];
    }
    return reverseString(r);
  }
  function Ctemp(name,price,img){
    if (img==0) {
      // img = 'https://alppetro.co.id/dist/assets/images/default.jpg';
      img = '';
    }else{
      img = `<img src="${img}" alt="foto barang" style="width: 30px" class="imgt">`;
    }
    var html = `<div class="col-lg-3 col-sm-6 p-2">
        <div class="card text-white bg-primary" style="max-width: 18rem;">
          <div class="card-header" style="display:flex">
            ${name.replace('>','-')}
            <div>
            ${img}
            </div>
          </div>
          <div class="d-flex flex-row bd-highlight">
            <h5 class="card-title" style="padding:10px">Rp${pricesp(price)}</h5>
          </div>
        </div>
      </div>`;
      return html;
  }
function Scari(){ 
    //membuat variabel val_cari dan mengisinya dengan nilai pada field cari
    var val_cari = $('#cari').val();
 
    //kode 1
    var request = $.ajax ({
        url : "/app/search",
        data : "q="+val_cari,
        type : "GET",
        dataType: "html"
    });
 
    //menampilkan pesan Sedang mencari saat aplikasi melakukan proses pencarian
    $('#hasil-cari').html('Sedang Mencari…');
 
    //Jika pencarian selesai
    request.done(function(output) {
        //Tampilkan hasil pencarian pada tag div dengan id hasil-cari
        var result = JSON.parse(output);
        var t = [];
        result.forEach(element =>
          t.push(Ctemp(element['name'], element['price'], element['image']))
          // console.log(element['id']);
        );
        var res = t.join('');
        $('#hasil-cari').html(res);
    });
 
}
Scari();
</script>
<?= view('footer') ?>