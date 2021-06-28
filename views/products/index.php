<h1>Products List</h1>
<p>
  <a href="/products/create" class="btn btn-success">Create Product</a>
</p>
<!-- Create Button End -->
<!-- Quick Search -->
<form action="">
  <div class="input-group mb-3">
    <input type="text" class="form-control" placeholder="Search for products" name="search" value="<?php echo $search ?>">
    <button class="btn btn-outline-secondary" type="submit">Search</button>
  </div>
</form>
<!-- Quick Search End -->
<!-- Table -->
<table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Image</th>
      <th scope="col">Title</th>
      <th scope="col">Price</th>
      <th scope="col">Created</th>
      <th scope="col">Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($products as $index => $product) : ?>
      <tr>
        <th scope="row"><?php echo $index + 1 ?></th>
        <td>
          <?php if ($product['image']): ?>
            <img src="/<?php echo $product['image'] ?>" class="thumb-img">
          <?php endif; ?>
        </td>
        <td><?php echo $product['title'] ?></td>
        <td><?php echo $product['price'] ?></td>
        <td><?php echo $product['create_date'] ?></td>
        <td>
          <a href="/products/update?id=<?php echo $product['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
          <form action="/products/delete" method="post" style="display:inline-block">
            <input type="hidden" name="id" value="<?php echo $product['id'] ?>">
            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
          </form>
        </td>
      </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<!-- Table End -->