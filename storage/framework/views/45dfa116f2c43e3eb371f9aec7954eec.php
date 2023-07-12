<table>
    <thead>
    <tr>
        <th>Código</th>
        <th>Nombre</th> 
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($value->voucherCode); ?></td>
            <td><?php echo e($value->voucherName); ?></td> 
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\backend-contable\resources\views/Excel/Export/typesQuoteExcel.blade.php ENDPATH**/ ?>