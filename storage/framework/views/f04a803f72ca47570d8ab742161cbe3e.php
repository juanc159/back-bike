<table>
    <thead>
    <tr>
        <th>Nombre</th> 
        <th>Referencia fábrica</th> 
        <th>Estado</th> 
        <th>Impuesto cargo</th> 
        <th>Descripción larga</th> 
    </tr>
    </thead>
    <tbody> 
    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($value->name); ?></td> 
            <td><?php echo e($value->factoryReference); ?></td> 
            <td><?php echo e($value->state==1 ? "Activo" : "Inactivo"); ?></td> 
            <td><?php echo e($value->taxCharge?->name); ?></td> 
            <td><?php echo e($value->description); ?></td>  
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH C:\laragon\www\backend-contable\resources\views/Excel/Export/ProductsExcel.blade.php ENDPATH**/ ?>