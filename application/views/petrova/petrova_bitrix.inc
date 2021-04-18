	<div class="table-wrapper lowered_30">
		<table>
			<thead>
				<tr>
					<th>Год</th>
					<th>Название</th>
                    <th>Документ</th>
					<th>Номер сертификата</th>
				</tr>
			</thead>
			<tbody>
			<?
			foreach ($this->bitrix as $document) { ?>
                <tr>
                    <td><?= $document["date"] ?></td>
                    <td><?= $document["name"] ?></td>
                    <td><a href="/petrova/rezume/certificate/id/<?= $document['id'] ?>" target="blank"
                           class="link-dashed blue"><?= $document["type"] ?></a>
                    </td>
                    <td><?= $document["number"] ?></td>
                </tr>
				<?
			} ?>
			</tbody>
		</table>
	</div>