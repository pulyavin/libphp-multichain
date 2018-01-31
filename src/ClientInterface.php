<?php

namespace pulyavin\Multichain;

/**
 * Class ClientInterface
 *
 * @package pulyavin\Multichain
 *
 * @link http://www.multichain.com/developers/json-rpc-api/
 */
interface ClientInterface
{
    /**
     * Generates one or more public/private key pairs, which are not stored in the wallet or drawn from the node’s key pool,
     * ready for external key management. For each key pair, the address, pubkey (as embedded in transaction inputs) and privkey
     * (used for signatures) is provided.
     *
     * @param int $count
     *
     * @return mixed
     */
    public function createKeypairs($count = 1);

    /**
     * Adds address (or a full public key, or an array of either) to the wallet, without an associated private key.
     * This creates one or more watch-only addresses, whose activity and balance can be retrieved via various APIs
     * (e.g. with the includeWatchOnly parameter), but whose funds cannot be spent by this node. If rescan is true,
     * the entire blockchain is checked for transactions relating to all addresses in the wallet, including the added ones.
     * Returns null if successful.
     *
     * @param $address
     * @param string $label
     * @param bool $rescan
     *
     * @return mixed
     */
    public function importAddress($address, $label = "", $rescan = true);

    /**
     * Lists information about the count most recent transactions related to address in this node’s wallet, including
     * how they affected that address’s balance. Use skip to go back further in history and verbose to provide details
     * of transaction inputs and outputs.
     *
     * @param $address
     * @param int $count
     * @param int $skip
     * @param bool $verbose
     *
     * @return mixed
     */
    public function listAddressTransactions($address, $count = 10, $skip = 0, $verbose = false);

    /**
     * Submits raw transaction (serialized, hex-encoded) to local node and network.
     * Returns the transaction hash in hex
     *
     * @param $hex
     * @param bool $allowHighFees
     *
     * @return mixed
     */
    public function sendRawTransaction($hex, $allowHighFees = false);

    /**
     * Signs the raw transaction in tx-hex, often provided by a previous call to createrawtransaction or
     * createrawsendfrom. Returns a raw hexadecimal transaction in the hex field alongside a complete field stating
     * whether it is now completely signed. If complete, the transaction can be broadcast to the network using
     * sendrawtransaction. If not, it can be passed to other parties for additional signing. To create chains of
     * unbroadcast transactions, pass an optional array of {parent-output} objects, each of which takes the form
     * {"txid":txid,"vout":n,"scriptPubKey":hex}. To sign using (only) private keys which are not in the node’s wallet,
     * pass an array of "private-key" strings, formatted as per the output of dumpprivkey. To sign only part of the
     * transaction, use the sighashtype parameter to control the signature hash type.
     *
     * @param $txHex
     * @param $parentOutput
     * @param $privkey
     * @param string $sigHashType
     *
     * @return mixed
     */
    public function signRawTransaction($txHex, $parentOutput, $privkey, $sigHashType = "ALL");

    /**
     * This works like createrawtransaction, except it automatically selects the transaction inputs from those
     * belonging to from-address, to cover the appropriate amounts. One or more change outputs going back to
     * from-address will also be added to the end of the transaction.
     *
     * @param $fromAddress
     * @param $inputs
     * @param $data
     * @param string $action
     *
     * @return mixed
     */
    public function createRawSendFrom($fromAddress, $inputs, $data, $action = "");
}
