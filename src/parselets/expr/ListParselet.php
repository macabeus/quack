<?php
/**
 * Quack Compiler and toolkit
 * Copyright (C) 2015-2017 Quack and CONTRIBUTORS
 *
 * This file is part of Quack.
 *
 * Quack is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Quack is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Quack.  If not, see <http://www.gnu.org/licenses/>.
 */
namespace QuackCompiler\Parselets\Expr;

use \QuackCompiler\Parser\Grammar;
use \QuackCompiler\Ast\Expr\ListExpr;
use \QuackCompiler\Lexer\Token;
use \QuackCompiler\Parselets\PrefixParselet;

class ListParselet implements PrefixParselet
{
    public function parse($grammar, Token $token)
    {
        $items = [];

        if ($grammar->reader->is('}')) {
            $grammar->reader->consume();
        } else {
            $items[] = $grammar->_expr();

            while ($grammar->reader->is(',')) {
                $grammar->reader->consume();
                $items[] = $grammar->_expr();
            }

            $grammar->reader->match('}');
        }

        return new ListExpr($items);
    }
}
