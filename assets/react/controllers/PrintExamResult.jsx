import React, { useEffect, useRef, useState } from 'react'
import { useReactToPrint } from 'react-to-print';

export default function PrintExamResult({ data, nom, prenom, id }) {
    const componentRef = useRef();
    const [content, setContent] = useState([])
    useEffect(() => {
        setContent(JSON.parse(data))

    }, [])
    const handlePrint = useReactToPrint({
        content: () => componentRef.current,
    });
    return <>

        <div className="card" ref={componentRef}>
            <h5 className="card-header">
                NOM: {nom} <br />
                PRENOM: {prenom} <br />
                Resultat examen: <strong>#EX-{id}</strong>
            </h5>
            <div className="table-responsive text-nowrap">
                <table className="table">
                    <thead>
                        <tr>
                            <th>Libelet</th>
                            <th>Value</th>
                            <th>Normal Value</th>
                        </tr>
                    </thead>
                    <tbody className="table-border-bottom-0">
                        {
                            content.map(el => <tr key={el.id}>
                                <td>
                                    {el.item.nom}
                                </td>
                                <td>
                                    {el.valeur}
                                </td>
                                <td>
                                    {el.item.normal_value ? el.item.normal_value : ""}
                                </td>
                            </tr>)
                        }
                    </tbody>
                </table>
            </div>
        </div>
        <button onClick={handlePrint} className="btn btn-primary mt-2">Print</button>
    </>
}