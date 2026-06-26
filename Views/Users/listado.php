<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Correo</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $user): ?>
            <tr>
                <td><?php echo $user['id']; ?></td>
                <td><?php echo $user['name']; ?></td>
                <td><?php echo $user['email']; ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>