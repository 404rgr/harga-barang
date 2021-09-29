<?= view('head') ?>
<style>
    th input,td input{
        width: 100%;
    }
</style>
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
      <?php
        if ($list) {
            echo "<h4>Results</h4>";
            echo $list;
        }
      ?>

    <h1 class="mt-5">Add Product</h1>
    <!-- <form> -->
        <div class="mb-3">
            <div class="form-floating">
                <textarea required class="form-control" placeholder="Leave a comment here" id="text" style="height: 107px;"></textarea>
                <label for="floatingTextarea">Format: (nama harga)(nama harga)...</label>
            </div>
        </div>
        <button type="button" onclick="submit_text()" class="btn btn-primary">Submit</button>
    <!-- </form> -->
    <div class="row d-flex col-lg-9 p-2" id="hasil-cari">
    <form action="?" method="post" id="pausi" style="display: none;">
        <table class="table table-hover" id="befi"></table>
        <button type="submit" class="btn btn-primary">Insert Data</button>
    </form>
  </div>
</main>
<script>
        Object.defineProperty(Array.prototype, 'chunk_inefficient', {
            value: function(chunkSize) {
                var array = this;
                return [].concat.apply([],
                array.map(function(elem, i) {
                    return i % chunkSize ? [] : [array.slice(i, i + chunkSize)];
                })
                );
            }
        });

        function create_bi(name, harga, x=false){
            if (x==true) {
                return `
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga(Rp)</th>
                </tr>`;
            }else{
                return  `
                <tr>
                    <td>
                        <input type="text" name="nama[]" value="${name}">
                    </td>
                    <td>
                        <input type="text" name="harga[]" value="${harga}">
                    </td>
                </tr>`;
            }
        }
        function proc(data) {
            var tmp = [];
            tmp.push(create_bi(0,0,true));
            for (let i = 0; i < data.length; i++) {
                const data2 = data[i];
                if (data2 && data2.length>1) {
                    tmp.push(create_bi(data2[0].trim(), data2[1].trim()));
                }
            }
            return tmp;
        }
        function submit_text(){
            var pausi = document.getElementById('pausi');
            var doc = document.getElementById('befi');
            var text = document.getElementById('text').value;
            var matchT = text.split(/Rp([0-9]*)/ig);
            var N_H = matchT.chunk_inefficient(2); //nama barang dan harga
            var res = proc(N_H);
            console.log(
                res.join('')
            );
            doc.innerHTML = res.join('');
            pausi.style.display = 'block';
        }
    </script>
<?= view('footer') ?>