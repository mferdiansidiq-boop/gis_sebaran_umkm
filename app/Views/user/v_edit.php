<?php /** @var string $judul */ ?>
 <?php /** @var array $user */ ?>

<div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <h3 class="card-title"><?= $judul ?></h3>

                
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body">
              <?php 
            // Mengambil service validation bawaan CodeIgniter 4 secara langsung
            $validation = \Config\Services::validation(); 
            ?>

            <?php echo form_open_multipart('User/UpdateData/' . $user['id_user']) ?>
              <div class="form-group">
                        <label>Nama User</label>
                        <input type="text" name="nama_user" value="<?= $user['nama_user'] ?>"placeholder="Nama User" class="form-control">
                        <p class="text-danger"><?= $validation->getError('nama_user') ?></p>
                    </div>

                    <div class="form-group">
                        <label>E-Mail</label>
                        <input type="text" name="email" value="<?= $user['email'] ?>"placeholder="E-Mail" class="form-control">
                        <p class="text-danger"><?= $validation->getError('email') ?></p>
                    </div>

                    <div class="form-group">
                        <label>Password</label>
                        <input type="text" name="password" value="<?= $user['password'] ?>"placeholder="Password" class="form-control">
                        <p class="text-danger"><?= $validation->getError('password') ?></p>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                        <label>Ganti Foto</label>
                        <input type="file" name="foto" value="<?= old('foto') ?>"placeholder="Foto" class="form-control">
                        <p class="text-danger"><?= $validation->getError('foto') ?></p>
                    </div>
                </div>
                <div class="col-sm-8">
                    <img src="<?= base_url('foto/' . $user['foto']) ?>" width="150px">
                  </div>
                  </div>

                    <button type="submit" class="btn btn-primary btn-flat">Simpan</button>
            <a href="<?= base_url('User') ?>" class="btn btn-success btn-flat">Kembali</a>

            <?php echo form_close() ?>

              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>