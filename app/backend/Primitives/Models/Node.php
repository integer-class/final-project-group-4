<?php

namespace Primitives\Models;

class Node
{
    public Approver $data;
    public ?Node $previous;
    public ?Node $next;

    public function __construct(Approver $data)
    {
        $this->data = $data;
        $this->previous = null;
        $this->next = null;
    }

    public static function fromArray(array $data)
    {
        if (empty($approvers)) {
            return null;
        }

        // Create a map to store nodes based on the 'data' value
        $nodeMap = [];

        // Create nodes for each approver
        foreach ($approvers as $approver) {
            $node = new Node($approver['data']);
            $nodeMap[$approver['data']] = $node;
        }

        // Connect nodes based on 'previous_approver' and 'next_approver' relationships
        foreach ($approvers as $approver) {
            $currentNode = $nodeMap[$approver['data']];

            if (!is_null($approver['previous_approver'])) {
                $currentNode->previous = $nodeMap[$approver['previous_approver']];
            }

            if (!is_null($approver['next_approver'])) {
                $currentNode->next = $nodeMap[$approver['next_approver']];
            }
        }

        // Find the head of the linked list
        $head = null;
        foreach ($nodeMap as $node) {
            if (is_null($node->previous_approver)) {
                $head = $node;
                break;
            }
        }

        return $head;
    }
}