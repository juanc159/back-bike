<table>
    <thead>
        <tr>
            <th>Item</th>
            <th>Tipo de vehículo</th>
            <th>Referencia</th>
            <th>Marca</th>
            <th>Modelo</th>
            <th>Color</th>
            <th>Placa</th>
            <th>Sitio Matricula</th>
            <th>Valor Retoma</th>
            <?php $__currentLoopData = $thirds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <td><?php echo e($value->name); ?></td>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <th>Total</th>
            <th>Utilidades</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td><?php echo e($key + 1); ?></td>
                <td><?php echo e($value->inventory?->vehicleType); ?></td>
                <td><?php echo e($value->inventory?->reference); ?></td>
                <td><?php echo e($value->inventory?->brand); ?></td>
                <td><?php echo e($value->inventory?->model); ?></td>
                <td><?php echo e($value->inventory?->color); ?></td>
                <td><?php echo e($value->inventory?->plate); ?></td>
                <td><?php echo e($value->inventory?->registrationSite); ?></td>
                <td><?php echo e($value->inventory?->value); ?></td>

                <?php $__currentLoopData = $thirds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key2 => $value2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(in_array($value2->id, array_column($value->thirds->toArray(), 'id'))): ?>
                        <?php $__currentLoopData = $value->thirds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key3 => $value3): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($value3->id == $value2->id): ?> 
                                <td><?php echo e($value3->pivot->amount); ?></td>
                            <?php endif; ?> 
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <td>0</td>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <td><?php echo e($value->total); ?></td>
                <td><?php echo e($value->utilities); ?></td>


            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    </tbody>
</table>
<?php /**PATH /var/www/back-bike/resources/views/Excel/Export/SalesExcel.blade.php ENDPATH**/ ?>