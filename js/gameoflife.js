// Retrieve the grid data from PHP using Smarty
const gridData = {$gridData|json_encode};

// Generate the HTML for the grid cells
let gridHTML = '';
for (let i = 0; i < gridData.length; i++) {
	gridHTML += '<tr>';
	for (let j = 0; j < gridData[i].length; j++) {
		const cellState = gridData[i][j] ? 'alive' : '';
		gridHTML += '<td class="' + cellState + '" onclick="toggleCellState(this)"></td>';
		}
	gridHTML += '</tr>';
	}

// Replace the placeholder in the template with the generated grid HTML
document.getElementById('grid').innerHTML = gridHTML;

// Function to toggle the state of a cell
function toggleCellState(cell) {
	if (cell !== null) {
		cell.classList.toggle('alive');
		const row = cell.parentNode.rowIndex;
		const col = cell.cellIndex;
		gridData[row][col] = !gridData[row][col];
	}
}