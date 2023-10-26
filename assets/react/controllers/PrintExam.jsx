import React, { useEffect, useRef, useState } from 'react';
import { useReactToPrint } from 'react-to-print';
export default function PrintExam(props) {
    const componentRef = useRef();
    const handlePrint = useReactToPrint({
        content: () => componentRef.current,
    });
    let { data, examId, payed = false } = props;
    let [id, setId] = useState(0);
    var [items, setItems] = useState([])
    useEffect(() => {
        setItems(JSON.parse(data))
        setId(examId);
    }, [])
    var dateJS = new Date();

    // Obtenir les composants de la date (jour, mois et année)
    const jour = dateJS.getUTCDate();
    const mois = dateJS.getUTCMonth() + 1; // Ajoutez 1 car les mois sont indexés à partir de 0
    var annee = dateJS.getUTCFullYear();
    console.log(items)
    const getTotale = () => {
        let total = 0;
        items.forEach(el => {
            total += el.prix;
        })

        return total;
    }
    return <>
        <div className="d-flex justify-content-between">
            <button className='btn btn-primary mb-2' onClick={handlePrint}><i className='bx bx-printer me-2' ></i> Imprimer</button>
        </div>
        <div ref={componentRef}>
            <strong>#EX-{id}</strong>
            <ol>
                {
                    items.map(item => {
                        return <li key={item.id}>
                            {item.nom} ({item.prix} XFA)
                        </li>
                    }
                    )
                }
            </ol>
            <strong>Total: {getTotale()} XFA</strong>
            <br />
            {payed ? <strong>Payé</strong> : "Non payé"}
        </div>

    </>;
}
