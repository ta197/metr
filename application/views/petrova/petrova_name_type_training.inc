<div class="table-wrapper lowered_30">
    <table>
        <thead>
        <tr>
            <th>Год</th>
            <th>Название</th>
            <th>Документ</th>
            <th>Кем выдан</th>
        </tr>
        </thead>
        <tbody>
		<? foreach ($this->{$code} as $document) { ?>
            <tr>
                <td><?= $document["date"] ?></td>
                <td><?= $document["name"] ?></td>
                <td><a href="/petrova/rezume/certificate/id/<?= $document['id'] ?>" target="blank" class="link-dashed blue"><?= $document["type"] ?></a>
                </td>
                <td>
		            <?php
		            if ($document['training_link'] && $document["training"]) { ?>
                        <a href="<?= $document['training_link'] ?>" target="blank" class="link-dashed blue">
				            <?= $document["training"] ?></a>
			        <?
		            } elseif ($document["training"]) {
			            echo $document["training"];
		            }
		            ?>
                </td>
            </tr>
		<? } ?>
        </tbody>
    </table>
</div>