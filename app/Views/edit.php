<?= view('head') ?>
<!-- Begin page content -->
<main class="flex-shrink-0">
  <div class="container">
      <br>
    <h1 class="mt-5">Cari harga barang dan edit</h1>
    <form class="d-flex col-lg-4" method="GET">
          <input value="<?php echo htmlspecialchars($_GET['q'] ?? '', ENT_QUOTES) ?>" name="q" id="cari" class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
    
    <div class="row d-flex col-lg-12 p-2" id="hasil-cari">
      <div>
        <?php
        if (isset($update)) {
            foreach ($update as $key => $value) {
                echo $value."<br>";
            }
        }
        ?>
      </div> 
      <form action="?" method="post">
        <table class="table table-hover" id="befi">
                <tbody><tr>
                    <th>Nama Barang</th>
                    <th>Harga(Rp)</th>
                </tr>
                <?php
                    $limit = 30; //limit to display data
                    foreach ($data as $key => $value) {
                        if ($key+1 > $limit) {
                            echo "<tr><td>Limit display $limit!</td><td><td></tr>";
                            break;
                        }
                        echo '<tr>
                        <td>
                            <input type="hidden" name="id[]" value="'.$value->id.'">
                            <input type="text" name="nama[]" value="'.$value->name.'">
                        </td>
                        <td>
                            <input type="text" name="harga[]" value="'.$value->price.'">
                        </td>
                    </tr>';
                    }
                ?>
            </tbody>
        </table>
        <button type="submit" class="btn btn-primary">Change Data</button>
    </form>
  </div>
</main>
<?= view('footer') ?>