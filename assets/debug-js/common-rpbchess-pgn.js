/******************************************************************************
 *                                                                            *
 *    This file is part of RPB Chessboard, a WordPress plugin.                *
 *    Copyright (C) 2013-2015  Yoann Le Montagner <yo35 -at- melix.net>       *
 *                                                                            *
 *    This program is free software: you can redistribute it and/or modify    *
 *    it under the terms of the GNU General Public License as published by    *
 *    the Free Software Foundation, either version 3 of the License, or       *
 *    (at your option) any later version.                                     *
 *                                                                            *
 *    This program is distributed in the hope that it will be useful,         *
 *    but WITHOUT ANY WARRANTY; without even the implied warranty of          *
 *    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the           *
 *    GNU General Public License for more details.                            *
 *                                                                            *
 *    You should have received a copy of the GNU General Public License       *
 *    along with this program.  If not, see <http://www.gnu.org/licenses/>.   *
 *                                                                            *
 ******************************************************************************/


/* jshint unused:false */
/* jshint globalstrict:true */
'use strict';

/* global RPBChess */
/* global registerException */


// Exception registration
registerException(RPBChess.exceptions.InvalidPGN, function(e) { return 'bad PGN >>' + e.pgn + '<< => ' + e.message; });


/**
 * Convert a game result code into a human-readable string.
 *
 * @param {number} gameResult
 * @returns {string}
 */
function wrapGameResult(gameResult) {
	switch(gameResult) {
		case RPBChess.pgn.gameresult.WHITE_WINS: return 'White wins';
		case RPBChess.pgn.gameresult.DRAW      : return 'Draw';
		case RPBChess.pgn.gameresult.BLACK_WINS: return 'Black wins';
		case RPBChess.pgn.gameresult.LINE      : return 'Line';
		default: return '&lt;unknown-result&gt;';
	}
}


/**
 * Dump the content of an item read from a `.pgn` file.
 *
 * @param {RPBChess.pgn.Item} pgnItem
 * @returns {string}
 */
function dumpPGNItem(pgnItem) {
	var res = '\n';

	// Dump the headers.
	var headers = pgnItem.headers();
	headers.sort();
	for(var k=0; k<headers.length; ++k) {
		var key  = headers[k];
		res += key + ' = {' + pgnItem.header(key) + '}\n';
	}

	// Recursive function to dump a variation.
	function dumpVariation(variation, indent, indentFirst) {

		// Variation header
		res += indentFirst + '-+';
		if(variation.isLongVariation()) {
			res += '<LONG';
		}
		for(var k=0; k<variation.nags().length; ++k) {
			res += ' $' + variation.nags()[k];
		}
		if(variation.comment() !== null) {
			res += ' {' + variation.comment() + '}';
			if(variation.isLongComment()) {
				res += '<LONG';
			}
		}
		res += '\n';

		// List of moves
		var node = variation.first();
		while(node !== null) {

			// Describe the move
			res += indent + node.fullMoveNumber() + (node.moveColor()==='w' ? '.' : '...') + node.move();
			for(var k=0; k<node.nags().length; ++k) {
				res += ' $' + node.nags()[k];
			}
			if(node.comment() !== null) {
				res += ' {' + node.comment() + '}';
				if(node.isLongComment()) {
					res += '<LONG';
				}
			}
			res += '\n';

			// Print the sub-variations
			for(var k=0; k<node.variations(); ++k) {
				res += indent + ' |\n';
				dumpVariation(node.variation(k), indent + ' |  ', indent + ' +--');
			}
			if(node.variations()>0) {
				res += indent + ' |\n';
			}

			// Go to the next move
			node = node.next();
		}
	}

	// Dump the moves and the result.
	dumpVariation(pgnItem.mainVariation(), '', '');
	res += '{' + wrapGameResult(pgnItem.result()) + '}\n';

	return res;
}