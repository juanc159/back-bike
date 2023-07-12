<table>
    <thead>
        <tr> 
          <th>
            Tipo
          </th>
          <th>
            Cliente
          </th>
          <th>
            Vendedor
          </th>
          <th>
            Moneda
          </th>
          <th>
            Fecha
          </th>
          <th>
            Numero
          </th>
          <th>
            total bruto
          </th>
          <th>
            descuento
          </th>
          <th>
            subtotal
          </th>
          <th>
            Total neto
          </th>
        </tr>
      </thead>
    <tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($value->typeQuote?->voucherName); ?></td>
            <td><?php echo e($value->third?->name,); ?></td>
            <td><?php echo e($value->user?->name); ?></td>
            <td><?php echo e($value->currency?->name); ?></td>
            <td><?php echo e($value->date_elaboration); ?></td>
            <td><?php echo e($value->number); ?></td>
            <td><?php echo e($value->gross_total); ?></td>
            <td><?php echo e($value->discount); ?></td>
            <td><?php echo e($value->subtotal); ?></td>
            <td><?php echo e($value->net_total); ?></td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\backend-contable\resources\views/Excel/Export/quoteExcel.blade.php ENDPATH**/ ?>